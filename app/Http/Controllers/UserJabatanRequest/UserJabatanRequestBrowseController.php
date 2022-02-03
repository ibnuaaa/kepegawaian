<?php

namespace App\Http\Controllers\UserJabatanRequest;

use App\Models\UserJabatanRequest;

use App\Traits\Browse;
use App\Traits\UserJabatanRequest\UserJabatanRequestCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserJabatanRequestBrowseController extends Controller
{
    use Browse, UserJabatanRequestCollection {
        UserJabatanRequestCollection::__construct as private __UserJabatanRequestCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserJabatanRequestCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserJabatanRequest = UserJabatanRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserJabatanRequestTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserJabatanRequestTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserJabatanRequest
            "$this->UserJabatanRequestTable.id as user_jabatan_request.id",
            "$this->UserJabatanRequestTable.name as user_jabatan_request.name",
            "$this->UserJabatanRequestTable.created_at as user_jabatan_request.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserJabatanRequest->orderBy("$this->UserJabatanRequestTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserJabatanRequest->orderBy("$this->UserJabatanRequestTable.created_at", $request->get('sort_type'));
            } else {
              $UserJabatanRequest->orderBy("$this->UserJabatanRequestTable.created_at", 'desc');
            }
        } else {
            $UserJabatanRequest->orderBy("$this->UserJabatanRequestTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserJabatanRequest, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_jabatan_request.', $item);
            }
            return $item;
        });
    }
}
