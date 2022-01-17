<?php

namespace App\Http\Controllers\Pendidikan;

use App\Models\Pendidikan;

use App\Traits\Browse;
use App\Traits\Pendidikan\PendidikanCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PendidikanBrowseController extends Controller
{
    use Browse, PendidikanCollection {
        PendidikanCollection::__construct as private __PendidikanCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PendidikanCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Pendidikan = Pendidikan::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PendidikanTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PendidikanTable.name", 'like', '%'.$request->get('name').'%');
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
            // Pendidikan
            "$this->PendidikanTable.id as pendidikan.id",
            "$this->PendidikanTable.name as pendidikan.name",
            "$this->PendidikanTable.created_at as pendidikan.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $Pendidikan->orderBy("$this->PendidikanTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $Pendidikan->orderBy("$this->PendidikanTable.created_at", $request->get('sort_type'));
            } else {
              $Pendidikan->orderBy("$this->PendidikanTable.created_at", 'desc');
            }
        } else {
            $Pendidikan->orderBy("$this->PendidikanTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $Pendidikan, function ($data) use($request) {
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
                $this->Group($item, $key, 'pendidikan.', $item);
            }
            return $item;
        });
    }
}
