<?php

namespace App\Http\Controllers\UserGolonganRequest;

use App\Models\UserGolonganRequest;

use App\Traits\Browse;
use App\Traits\UserGolonganRequest\UserGolonganRequestCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserGolonganRequestBrowseController extends Controller
{
    use Browse, UserGolonganRequestCollection {
        UserGolonganRequestCollection::__construct as private __UserGolonganRequestCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserGolonganRequestCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserGolonganRequest = UserGolonganRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserGolonganRequestTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserGolonganRequestTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserGolonganRequest
            "$this->UserGolonganRequestTable.id as user_golongan_request.id",
            "$this->UserGolonganRequestTable.name as user_golongan_request.name",
            "$this->UserGolonganRequestTable.created_at as user_golongan_request.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserGolonganRequest->orderBy("$this->UserGolonganRequestTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserGolonganRequest->orderBy("$this->UserGolonganRequestTable.created_at", $request->get('sort_type'));
            } else {
              $UserGolonganRequest->orderBy("$this->UserGolonganRequestTable.created_at", 'desc');
            }
        } else {
            $UserGolonganRequest->orderBy("$this->UserGolonganRequestTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserGolonganRequest, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_golongan_request.', $item);
            }
            return $item;
        });
    }
}
