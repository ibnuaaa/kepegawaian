<?php

namespace App\Http\Controllers\UploadAbsensi;

use App\Models\UploadAbsensi;

use App\Traits\Browse;
use App\Traits\UploadAbsensi\UploadAbsensiCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UploadAbsensiBrowseController extends Controller
{
    use Browse, UploadAbsensiCollection {
        UploadAbsensiCollection::__construct as private __UploadAbsensiCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UploadAbsensiCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UploadAbsensi = UploadAbsensi::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UploadAbsensiTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UploadAbsensiTable.name", 'like', '%'.$request->get('name').'%');
                });
            }

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
        })->with('upload_absensi_detail');

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UploadAbsensi->orderBy("$this->UploadAbsensiTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UploadAbsensi->orderBy("$this->UploadAbsensiTable.created_at", $request->get('sort_type'));
            } else {
              $UploadAbsensi->orderBy("$this->UploadAbsensiTable.created_at", 'desc');
            }
        } else {
            $UploadAbsensi->orderBy("$this->UploadAbsensiTable.created_at", 'desc');
        }

        $Browse = $this->Browse($request, $UploadAbsensi, function ($data) use($request) {
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
                $this->Group($item, $key, 'upload_absensi.', $item);
            }
            return $item;
        });
    }
}
