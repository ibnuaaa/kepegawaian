<?php

namespace App\Http\Controllers\IndikatorTetap;

use App\Models\IndikatorTetap;

use App\Traits\Browse;
use App\Traits\IndikatorTetap\IndikatorTetapCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class IndikatorTetapBrowseController extends Controller
{
    use Browse, IndikatorTetapCollection {
        IndikatorTetapCollection::__construct as private __IndikatorTetapCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__IndikatorTetapCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $IndikatorTetap = IndikatorTetap::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->IndikatorTetapTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->IndikatorTetapTable.name", 'like', '%'.$request->get('name').'%');
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
            // IndikatorTetap
            "$this->IndikatorTetapTable.id as indikator_tetap.id",
            "$this->IndikatorTetapTable.name as indikator_tetap.name",
            "$this->IndikatorTetapTable.type as indikator_tetap.type",
            "$this->IndikatorTetapTable.created_at as indikator_tetap.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $IndikatorTetap->orderBy("$this->IndikatorTetapTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $IndikatorTetap->orderBy("$this->IndikatorTetapTable.created_at", $request->get('sort_type'));
            } else {
              $IndikatorTetap->orderBy("$this->IndikatorTetapTable.created_at", 'desc');
            }
        } else {
            $IndikatorTetap->orderBy("$this->IndikatorTetapTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $IndikatorTetap, function ($data) use($request) {
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
                $this->Group($item, $key, 'indikator_tetap.', $item);
            }
            return $item;
        });
    }
}
