<?php

namespace App\Http\Controllers\UserJabatan;

use App\Models\UserJabatan;

use App\Traits\Browse;
use App\Traits\UserJabatan\UserJabatanCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UserJabatanBrowseController extends Controller
{
    use Browse, UserJabatanCollection {
        UserJabatanCollection::__construct as private __UserJabatanCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserJabatanCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserJabatan = UserJabatan::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UserJabatanTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserJabatanTable.name", 'like', '%'.$request->get('name').'%');
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
            // UserJabatan
            "$this->UserJabatanTable.id as user_pendidikan.id",
            "$this->UserJabatanTable.name as user_pendidikan.name",
            "$this->UserJabatanTable.created_at as user_pendidikan.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UserJabatan->orderBy("$this->UserJabatanTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UserJabatan->orderBy("$this->UserJabatanTable.created_at", $request->get('sort_type'));
            } else {
              $UserJabatan->orderBy("$this->UserJabatanTable.created_at", 'desc');
            }
        } else {
            $UserJabatan->orderBy("$this->UserJabatanTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UserJabatan, function ($data) use($request) {
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
