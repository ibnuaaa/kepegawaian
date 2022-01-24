<?php

namespace App\Http\Controllers\IndikatorSkp;

use App\Models\IndikatorSkp;

use App\Traits\Browse;
use App\Traits\IndikatorSkp\IndikatorSkpCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class IndikatorSkpBrowseController extends Controller
{
    use Browse, IndikatorSkpCollection {
        IndikatorSkpCollection::__construct as private __IndikatorSkpCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__IndikatorSkpCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $IndikatorSkp = IndikatorSkp::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->IndikatorSkpTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->unit_kerja_id)) {
                $query->where("$this->IndikatorSkpTable.unit_kerja_id", $request->ArrQuery->unit_kerja_id);
            }

            if (isset($request->ArrQuery->tipe_indikator)) {
                $query->where("$this->IndikatorSkpTable.tipe_indikator", $request->ArrQuery->tipe_indikator);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->IndikatorSkpTable.name", 'like', '%'.$request->get('name').'%');
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
        })
        ->select(
            // IndikatorSkp
            "$this->IndikatorSkpTable.id as indikator_skp.id",
            "$this->IndikatorSkpTable.name as indikator_skp.name",
            "$this->IndikatorSkpTable.created_at as indikator_skp.created_at"
        )->with('indikator_skp_child');

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $IndikatorSkp->orderBy("$this->IndikatorSkpTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $IndikatorSkp->orderBy("$this->IndikatorSkpTable.created_at", $request->get('sort_type'));
            } else {
              $IndikatorSkp->orderBy("$this->IndikatorSkpTable.created_at", 'desc');
            }
        } else {
            $IndikatorSkp->orderBy("$this->IndikatorSkpTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $IndikatorSkp, function ($data) use($request) {
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
                $this->Group($item, $key, 'indikator_skp.', $item);
            }
            return $item;
        });
    }
}
