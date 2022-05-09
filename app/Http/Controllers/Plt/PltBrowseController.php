<?php

namespace App\Http\Controllers\Plt;

use App\Models\Plt;

use App\Traits\Browse;
use App\Traits\Plt\PltCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PltBrowseController extends Controller
{
    use Browse, PltCollection {
        PltCollection::__construct as private __PltCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PltCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Plt = Plt::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PltTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PltTable.name", 'like', '%'.$request->get('name').'%');
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
            // Plt
            "$this->PltTable.id as plt.id",
            "$this->PltTable.name as plt.name",
            "$this->PltTable.created_at as plt.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $Plt->orderBy("$this->PltTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $Plt->orderBy("$this->PltTable.created_at", $request->get('sort_type'));
            } else {
              $Plt->orderBy("$this->PltTable.created_at", 'desc');
            }
        } else {
            $Plt->orderBy("$this->PltTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $Plt, function ($data) use($request) {
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
                $this->Group($item, $key, 'plt.', $item);
            }
            return $item;
        });
    }
}
