<?php

namespace App\Http\Controllers\UserJabatanFungsional;

use App\Models\UserJabatanFungsional;

use App\Traits\Browse;
use App\Traits\UserJabatanFungsional\UserJabatanFungsionalCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserJabatanFungsionalBrowseController extends Controller
{
    use Browse, UserJabatanFungsionalCollection {
        UserJabatanFungsionalCollection::__construct as private __UserJabatanFungsionalCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserJabatanFungsionalCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserJabatanFungsional = UserJabatanFungsional::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserJabatanFungsionalTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserJabatanFungsionalTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserJabatanFungsional
            "$this->UserJabatanFungsionalTable.id as user_jabatan_fungsional.id",
            "$this->UserJabatanFungsionalTable.name as user_jabatan_fungsional.name",
            "$this->UserJabatanFungsionalTable.created_at as user_jabatan_fungsional.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserJabatanFungsional->orderBy("$this->UserJabatanFungsionalTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserJabatanFungsional->orderBy("$this->UserJabatanFungsionalTable.created_at", $request->get('sort_type'));
            } else {
              $UserJabatanFungsional->orderBy("$this->UserJabatanFungsionalTable.created_at", 'desc');
            }
        } else {
            $UserJabatanFungsional->orderBy("$this->UserJabatanFungsionalTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserJabatanFungsional, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_jabatan_fungsional.', $item);
            }
            return $item;
        });
    }
}
