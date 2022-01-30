<?php

namespace App\Http\Controllers\JabatanFungsional;

use App\Models\JabatanFungsional;

use App\Traits\Browse;
use App\Traits\JabatanFungsional\JabatanFungsionalCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class JabatanFungsionalBrowseController extends Controller
{
    use Browse, JabatanFungsionalCollection {
        JabatanFungsionalCollection::__construct as private __JabatanFungsionalCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__JabatanFungsionalCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $JabatanFungsional = JabatanFungsional::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->JabatanFungsionalTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->JabatanFungsionalTable.name", 'like', '%'.$request->get('name').'%');
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
            // JabatanFungsional
            "$this->JabatanFungsionalTable.id as jabatan_fungsional.id",
            "$this->JabatanFungsionalTable.name as jabatan_fungsional.name",
            "$this->JabatanFungsionalTable.created_at as jabatan_fungsional.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $JabatanFungsional->orderBy("$this->JabatanFungsionalTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $JabatanFungsional->orderBy("$this->JabatanFungsionalTable.created_at", $request->get('sort_type'));
            } else {
              $JabatanFungsional->orderBy("$this->JabatanFungsionalTable.created_at", 'desc');
            }
        } else {
            $JabatanFungsional->orderBy("$this->JabatanFungsionalTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $JabatanFungsional, function ($data) use($request) {
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
                $this->Group($item, $key, 'jabatan_fungsional.', $item);
            }
            return $item;
        });
    }
}
