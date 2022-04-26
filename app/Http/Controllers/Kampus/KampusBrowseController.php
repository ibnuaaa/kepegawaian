<?php

namespace App\Http\Controllers\Kampus;

use App\Models\Kampus;

use App\Traits\Browse;
use App\Traits\Kampus\KampusCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class KampusBrowseController extends Controller
{
    use Browse, KampusCollection {
        KampusCollection::__construct as private __KampusCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__KampusCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Kampus = Kampus::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->KampusTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->KampusTable.name", 'like', '%'.$request->get('name').'%');
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
            // Kampus
            "$this->KampusTable.id as kampus.id",
            "$this->KampusTable.name as kampus.name",
            "$this->KampusTable.created_at as kampus.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $Kampus->orderBy("$this->KampusTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $Kampus->orderBy("$this->KampusTable.created_at", $request->get('sort_type'));
            } else {
              $Kampus->orderBy("$this->KampusTable.created_at", 'desc');
            }
        } else {
            $Kampus->orderBy("$this->KampusTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $Kampus, function ($data) use($request) {
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
                $this->Group($item, $key, 'kampus.', $item);
            }
            return $item;
        });
    }
}
