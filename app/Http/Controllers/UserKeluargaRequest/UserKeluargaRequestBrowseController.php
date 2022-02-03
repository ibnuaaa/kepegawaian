<?php

namespace App\Http\Controllers\UserKeluargaRequest;

use App\Models\UserKeluargaRequest;

use App\Traits\Browse;
use App\Traits\UserKeluargaRequest\UserKeluargaRequestCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserKeluargaRequestBrowseController extends Controller
{
    use Browse, UserKeluargaRequestCollection {
        UserKeluargaRequestCollection::__construct as private __UserKeluargaRequestCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserKeluargaRequestCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserKeluargaRequest = UserKeluargaRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserKeluargaRequestTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserKeluargaRequestTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserKeluargaRequest
            "$this->UserKeluargaRequestTable.id as user_keluarga_request.id",
            "$this->UserKeluargaRequestTable.name as user_keluarga_request.name",
            "$this->UserKeluargaRequestTable.created_at as user_keluarga_request.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserKeluargaRequest->orderBy("$this->UserKeluargaRequestTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserKeluargaRequest->orderBy("$this->UserKeluargaRequestTable.created_at", $request->get('sort_type'));
            } else {
              $UserKeluargaRequest->orderBy("$this->UserKeluargaRequestTable.created_at", 'desc');
            }
        } else {
            $UserKeluargaRequest->orderBy("$this->UserKeluargaRequestTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserKeluargaRequest, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_keluarga_request.', $item);
            }
            return $item;
        });
    }
}
