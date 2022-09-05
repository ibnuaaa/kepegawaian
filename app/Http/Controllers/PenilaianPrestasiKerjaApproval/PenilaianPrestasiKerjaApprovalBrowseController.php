<?php

namespace App\Http\Controllers\PenilaianPrestasiKerjaApproval;

use App\Models\PenilaianPrestasiKerjaApproval;

use App\Traits\Browse;
use App\Traits\PenilaianPrestasiKerjaApproval\PenilaianPrestasiKerjaApprovalCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PenilaianPrestasiKerjaApprovalBrowseController extends Controller
{
    use Browse, PenilaianPrestasiKerjaApprovalCollection {
        PenilaianPrestasiKerjaApprovalCollection::__construct as private __PenilaianPrestasiKerjaApprovalCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PenilaianPrestasiKerjaApprovalCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApproval::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PenilaianPrestasiKerjaApprovalTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->for)) {
                if ($request->ArrQuery->for == 'approval') {
                  $query->where(function ($query) use($request) {
                        $query->where(function ($query) use($request) {
                            $query->whereHas("user", function ($query) use($request) {
                                $query->whereHas("jabatan", function ($query) use($request) {
                                    $query->where('is_staff', 1);
                                });
                            });
                            $query->whereHas("user", function ($query) use($request) {
                                $query->where('unit_kerja_id', MyAccount()->unit_kerja_id);
                            });
                        });


                        $query->orWhere(function ($query) use($request) {
                            $query->whereHas("user", function ($query) use($request) {
                              $query->whereHas("unit_kerja", function ($query) use($request) {
                                  $query->where('parent_id', MyAccount()->unit_kerja_id);
                              });
                            });

                            $query->whereHas("user", function ($query) use($request) {
                                $query->whereHas("jabatan", function ($query) use($request) {
                                    $query->whereNull('is_staff');
                                    $query->orWhere('is_staff', 0);
                                });
                            });
                        });
                    });
                } else if ($request->ArrQuery->for == 'approval_penilaian') {
                    $query->has("foto_penilaian_prestasi_kerja");
                }
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PenilaianPrestasiKerjaApprovalTable.name", 'like', '%'.$request->get('name').'%');
                });
            }

            $query->where('user_id', '!=', Auth::user()->id);

            if (!empty($request->ArrQuery->search)) {
                $searched = explode(' ',$request->ArrQuery->search);
                foreach ($searched as $key => $value) {
                    $query->where(function ($query) use($request, $value) {
                        $search = '%' . $value . '%';
                        foreach ($this->search as $keySearch => $valueSearch) {
                            $query->orWhere($valueSearch, 'like', $search);
                        }
                    });
                }
            }
        })->with(
          'penilaian_prestasi_kerja'
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'created_at') $PenilaianPrestasiKerjaApproval->orderBy("$this->PenilaianPrestasiKerjaApprovalTable.created_at", $request->get('sort_type'));
            } else {
              $PenilaianPrestasiKerjaApproval->orderBy("$this->PenilaianPrestasiKerjaApprovalTable.created_at", 'desc');
            }
        } else {
            $PenilaianPrestasiKerjaApproval->orderBy("$this->PenilaianPrestasiKerjaApprovalTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $PenilaianPrestasiKerjaApproval, function ($data) use($request) {
            $data = $this->Manipulate($data);
            return $data;
       });
       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'PenilaianPrestasiKerjaApproval.', $item);
            }
            return $item;
        });
    }
}
