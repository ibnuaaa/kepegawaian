<?php

namespace App\Http\Controllers\PerilakuKerja;

use App\Models\PerilakuKerja;

use App\Traits\Browse;
use App\Traits\PerilakuKerja\PerilakuKerjaCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PerilakuKerjaBrowseController extends Controller
{
    use Browse, PerilakuKerjaCollection {
        PerilakuKerjaCollection::__construct as private __PerilakuKerjaCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PerilakuKerjaCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $PerilakuKerja = PerilakuKerja::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PerilakuKerjaTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PerilakuKerjaTable.name", 'like', '%'.$request->get('name').'%');
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
            // PerilakuKerja
            "$this->PerilakuKerjaTable.id as perilaku_kerja.id",
            "$this->PerilakuKerjaTable.name as perilaku_kerja.name",
            "$this->PerilakuKerjaTable.created_at as perilaku_kerja.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $PerilakuKerja->orderBy("$this->PerilakuKerjaTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $PerilakuKerja->orderBy("$this->PerilakuKerjaTable.created_at", $request->get('sort_type'));
            } else {
              $PerilakuKerja->orderBy("$this->PerilakuKerjaTable.created_at", 'desc');
            }
        } else {
            $PerilakuKerja->orderBy("$this->PerilakuKerjaTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $PerilakuKerja, function ($data) use($request) {
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
                $this->Group($item, $key, 'perilaku_kerja.', $item);
            }
            return $item;
        });
    }
}
