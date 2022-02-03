<?php

namespace App\Http\Controllers\UserPelatihanRequest;

use App\Models\UserPelatihanRequest;

use App\Traits\Browse;
use App\Traits\UserPelatihanRequest\UserPelatihanRequestCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserPelatihanRequestBrowseController extends Controller
{
    use Browse, UserPelatihanRequestCollection {
        UserPelatihanRequestCollection::__construct as private __UserPelatihanRequestCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserPelatihanRequestCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserPelatihanRequest = UserPelatihanRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserPelatihanRequestTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserPelatihanRequestTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserPelatihanRequest
            "$this->UserPelatihanRequestTable.id as user_pelatihan_request.id",
            "$this->UserPelatihanRequestTable.name as user_pelatihan_request.name",
            "$this->UserPelatihanRequestTable.created_at as user_pelatihan_request.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserPelatihanRequest->orderBy("$this->UserPelatihanRequestTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserPelatihanRequest->orderBy("$this->UserPelatihanRequestTable.created_at", $request->get('sort_type'));
            } else {
              $UserPelatihanRequest->orderBy("$this->UserPelatihanRequestTable.created_at", 'desc');
            }
        } else {
            $UserPelatihanRequest->orderBy("$this->UserPelatihanRequestTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserPelatihanRequest, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_pelatihan_request.', $item);
            }
            return $item;
        });
    }
}
