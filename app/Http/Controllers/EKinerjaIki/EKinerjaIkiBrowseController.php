<?php

namespace App\Http\Controllers\EKinerjaIki;

use App\Models\EKinerjaIki;

use App\Traits\Browse;
use App\Traits\EKinerjaIki\EKinerjaIkiCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class EKinerjaIkiBrowseController extends Controller
{
    use Browse, EKinerjaIkiCollection {
        EKinerjaIkiCollection::__construct as private __EKinerjaIkiCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__EKinerjaIkiCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $EKinerjaIki = EKinerjaIki::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->EKinerjaIkiTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->EKinerjaIkiTable.name", 'like', '%'.$request->get('name').'%');
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
        })->with('e_kinerja_iki_detail');

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $EKinerjaIki->orderBy("$this->EKinerjaIkiTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $EKinerjaIki->orderBy("$this->EKinerjaIkiTable.created_at", $request->get('sort_type'));
            } else {
              $EKinerjaIki->orderBy("$this->EKinerjaIkiTable.created_at", 'desc');
            }
        } else {
            $EKinerjaIki->orderBy("$this->EKinerjaIkiTable.created_at", 'desc');
        }

        $Browse = $this->Browse($request, $EKinerjaIki, function ($data) use($request) {
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
                $this->Group($item, $key, 'e_kinerja_iki.', $item);
            }
            return $item;
        });
    }
}
