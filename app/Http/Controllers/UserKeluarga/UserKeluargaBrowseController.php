<?php

namespace App\Http\Controllers\UserKeluarga;

use App\Models\UserKeluarga;

use App\Traits\Browse;
use App\Traits\UserKeluarga\UserKeluargaCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserKeluargaBrowseController extends Controller
{
    use Browse, UserKeluargaCollection {
        UserKeluargaCollection::__construct as private __UserKeluargaCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserKeluargaCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserKeluarga = UserKeluarga::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserKeluargaTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserKeluargaTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserKeluarga
            "$this->UserKeluargaTable.id as user_pendidikan.id",
            "$this->UserKeluargaTable.name as user_pendidikan.name",
            "$this->UserKeluargaTable.created_at as user_pendidikan.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserKeluarga->orderBy("$this->UserKeluargaTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserKeluarga->orderBy("$this->UserKeluargaTable.created_at", $request->get('sort_type'));
            } else {
              $UserKeluarga->orderBy("$this->UserKeluargaTable.created_at", 'desc');
            }
        } else {
            $UserKeluarga->orderBy("$this->UserKeluargaTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserKeluarga, function ($data) use($request) {
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
                $this->Group($item, $key, 'user_pendidikan.', $item);
            }
            return $item;
        });
    }
}
