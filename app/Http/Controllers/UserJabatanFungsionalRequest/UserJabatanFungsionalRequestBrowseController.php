<?php

namespace App\Http\Controllers\UserJabatanFungsionalRequest;

use App\Models\UserJabatanFungsionalRequest;

use App\Traits\Browse;
use App\Traits\UserJabatanFungsionalRequest\UserJabatanFungsionalRequestCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserJabatanFungsionalRequestBrowseController extends Controller
{
    use Browse, UserJabatanFungsionalRequestCollection {
        UserJabatanFungsionalRequestCollection::__construct as private __UserJabatanFungsionalRequestCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserJabatanFungsionalRequestCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserJabatanFungsionalRequest = UserJabatanFungsionalRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserJabatanFungsionalRequestTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserJabatanFungsionalRequestTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserJabatanFungsionalRequest
            "$this->UserJabatanFungsionalRequestTable.id as user_jabatan_fungsional_request.id",
            "$this->UserJabatanFungsionalRequestTable.name as user_jabatan_fungsional_request.name",
            "$this->UserJabatanFungsionalRequestTable.created_at as user_jabatan_fungsional_request.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserJabatanFungsionalRequest->orderBy("$this->UserJabatanFungsionalRequestTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserJabatanFungsionalRequest->orderBy("$this->UserJabatanFungsionalRequestTable.created_at", $request->get('sort_type'));
            } else {
              $UserJabatanFungsionalRequest->orderBy("$this->UserJabatanFungsionalRequestTable.created_at", 'desc');
            }
        } else {
            $UserJabatanFungsionalRequest->orderBy("$this->UserJabatanFungsionalRequestTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserJabatanFungsionalRequest, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_jabatan_fungsional_request.', $item);
            }
            return $item;
        });
    }
}
