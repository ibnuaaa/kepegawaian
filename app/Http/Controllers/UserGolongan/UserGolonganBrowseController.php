<?php

namespace App\Http\Controllers\UserGolongan;

use App\Models\UserGolongan;

use App\Traits\Browse;
use App\Traits\UserGolongan\UserGolonganCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserGolonganBrowseController extends Controller
{
    use Browse, UserGolonganCollection {
        UserGolonganCollection::__construct as private __UserGolonganCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserGolonganCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserGolongan = UserGolongan::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserGolonganTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserGolonganTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserGolongan
            "$this->UserGolonganTable.id as user_golongan.id",
            "$this->UserGolonganTable.name as user_golongan.name",
            "$this->UserGolonganTable.created_at as user_golongan.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserGolongan->orderBy("$this->UserGolonganTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserGolongan->orderBy("$this->UserGolonganTable.created_at", $request->get('sort_type'));
            } else {
              $UserGolongan->orderBy("$this->UserGolonganTable.created_at", 'desc');
            }
        } else {
            $UserGolongan->orderBy("$this->UserGolonganTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserGolongan, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_golongan.', $item);
            }
            return $item;
        });
    }
}
