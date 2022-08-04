<?php

namespace App\Http\Controllers\EKinerjaIkt;

use App\Models\EKinerjaIkt;

use App\Traits\Browse;
use App\Traits\EKinerjaIkt\EKinerjaIktCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class EKinerjaIktBrowseController extends Controller
{
    use Browse, EKinerjaIktCollection {
        EKinerjaIktCollection::__construct as private __EKinerjaIktCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__EKinerjaIktCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $EKinerjaIkt = EKinerjaIkt::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->EKinerjaIktTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->EKinerjaIktTable.name", 'like', '%'.$request->get('name').'%');
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
        })->with('e_kinerja_ikt_detail');

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $EKinerjaIkt->orderBy("$this->EKinerjaIktTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $EKinerjaIkt->orderBy("$this->EKinerjaIktTable.created_at", $request->get('sort_type'));
            } else {
              $EKinerjaIkt->orderBy("$this->EKinerjaIktTable.created_at", 'desc');
            }
        } else {
            $EKinerjaIkt->orderBy("$this->EKinerjaIktTable.created_at", 'desc');
        }

        $Browse = $this->Browse($request, $EKinerjaIkt, function ($data) use($request) {
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
                $this->Group($item, $key, 'e_kinerja_ikt.', $item);
            }
            return $item;
        });
    }
}
