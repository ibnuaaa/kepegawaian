<?php

namespace App\Http\Controllers\IndikatorKinerja;

use App\Models\IndikatorKinerja;

use App\Traits\Browse;
use App\Traits\IndikatorKinerja\IndikatorKinerjaCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class IndikatorKinerjaBrowseController extends Controller
{
    use Browse, IndikatorKinerjaCollection {
        IndikatorKinerjaCollection::__construct as private __IndikatorKinerjaCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__IndikatorKinerjaCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $IndikatorKinerja = IndikatorKinerja::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->IndikatorKinerjaTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->IndikatorKinerjaTable.name", 'like', '%'.$request->get('name').'%');
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
            // IndikatorKinerja
            "$this->IndikatorKinerjaTable.id as indikator_kinerja.id",
            "$this->IndikatorKinerjaTable.name as indikator_kinerja.name",
            "$this->IndikatorKinerjaTable.created_at as indikator_kinerja.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $IndikatorKinerja->orderBy("$this->IndikatorKinerjaTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $IndikatorKinerja->orderBy("$this->IndikatorKinerjaTable.created_at", $request->get('sort_type'));
            } else {
              $IndikatorKinerja->orderBy("$this->IndikatorKinerjaTable.created_at", 'desc');
            }
        } else {
            $IndikatorKinerja->orderBy("$this->IndikatorKinerjaTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $IndikatorKinerja, function ($data) use($request) {
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
                $this->Group($item, $key, 'indikator_kinerja.', $item);
            }
            return $item;
        });
    }
}
