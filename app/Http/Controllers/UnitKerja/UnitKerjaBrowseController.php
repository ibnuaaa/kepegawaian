<?php

namespace App\Http\Controllers\UnitKerja;

use App\Models\UnitKerja;

use App\Traits\Browse;
use App\Traits\UnitKerja\UnitKerjaCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class UnitKerjaBrowseController extends Controller
{
    use Browse, UnitKerjaCollection {
        UnitKerjaCollection::__construct as private __UnitKerjaCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UnitKerjaCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UnitKerja = UnitKerja::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->UnitKerjaTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UnitKerjaTable.name", 'like', '%'.$request->get('name').'%');
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
            // UnitKerja
            "$this->UnitKerjaTable.id as unit_kerja.id",
            "$this->UnitKerjaTable.name as unit_kerja.name",
            "$this->UnitKerjaTable.created_at as unit_kerja.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $UnitKerja->orderBy("$this->UnitKerjaTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $UnitKerja->orderBy("$this->UnitKerjaTable.created_at", $request->get('sort_type'));
            } else {
              $UnitKerja->orderBy("$this->UnitKerjaTable.created_at", 'desc');
            }
        } else {
            $UnitKerja->orderBy("$this->UnitKerjaTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $UnitKerja, function ($data) use($request) {
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
                $this->Group($item, $key, 'unit_kerja.', $item);
            }
            return $item;
        });
    }
}
