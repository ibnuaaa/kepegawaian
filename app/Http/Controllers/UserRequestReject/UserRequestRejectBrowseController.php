<?php

namespace App\Http\Controllers\UserRequestReject;

use App\Models\UserRequestReject;

use App\Traits\Browse;
use App\Traits\UserRequestReject\UserRequestRejectCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserRequestRejectBrowseController extends Controller
{
    use Browse, UserRequestRejectCollection {
        UserRequestRejectCollection::__construct as private __UserRequestRejectCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserRequestRejectCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserRequestReject = UserRequestReject::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserRequestRejectTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->user_request_id)) {
                $query->where("$this->UserRequestRejectTable.user_request_id", $request->ArrQuery->user_request_id);
            }

            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserRequestRejectTable.status", $request->ArrQuery->status);
            }


            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserRequestRejectTable.description", 'like', '%'.$request->get('name').'%');
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
            // UserRequestReject
            "$this->UserRequestRejectTable.id as user_request_reject.id",
            "$this->UserRequestRejectTable.description as user_request_reject.description",
            "$this->UserRequestRejectTable.created_at as user_request_reject.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserRequestReject->orderBy("$this->UserRequestRejectTable.description", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserRequestReject->orderBy("$this->UserRequestRejectTable.created_at", $request->get('sort_type'));
            } else {
              $UserRequestReject->orderBy("$this->UserRequestRejectTable.created_at", 'desc');
            }
        } else {
            $UserRequestReject->orderBy("$this->UserRequestRejectTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserRequestReject, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_request_reject.', $item);
            }
            return $item;
        });
    }
}
