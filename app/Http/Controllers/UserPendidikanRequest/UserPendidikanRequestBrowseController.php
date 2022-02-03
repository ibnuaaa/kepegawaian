<?php

namespace App\Http\Controllers\UserPendidikanRequest;

use App\Models\UserPendidikanRequest;

use App\Traits\Browse;
use App\Traits\UserPendidikanRequest\UserPendidikanRequestCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserPendidikanRequestBrowseController extends Controller
{
    use Browse, UserPendidikanRequestCollection {
        UserPendidikanRequestCollection::__construct as private __UserPendidikanRequestCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserPendidikanRequestCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserPendidikanRequest = UserPendidikanRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserPendidikanRequestTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserPendidikanRequestTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserPendidikanRequest
            "$this->UserPendidikanRequestTable.id as user_pendidikan_request.id",
            "$this->UserPendidikanRequestTable.name as user_pendidikan_request.name",
            "$this->UserPendidikanRequestTable.created_at as user_pendidikan_request.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserPendidikanRequest->orderBy("$this->UserPendidikanRequestTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserPendidikanRequest->orderBy("$this->UserPendidikanRequestTable.created_at", $request->get('sort_type'));
            } else {
              $UserPendidikanRequest->orderBy("$this->UserPendidikanRequestTable.created_at", 'desc');
            }
        } else {
            $UserPendidikanRequest->orderBy("$this->UserPendidikanRequestTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserPendidikanRequest, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_pendidikan_request.', $item);
            }
            return $item;
        });
    }
}
