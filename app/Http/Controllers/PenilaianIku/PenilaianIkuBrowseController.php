<?php

namespace App\Http\Controllers\PenilaianIku;

use App\Models\PenilaianIku;

use App\Traits\Browse;
use App\Traits\PenilaianIku\PenilaianIkuCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PenilaianIkuBrowseController extends Controller
{
    use Browse, PenilaianIkuCollection {
        PenilaianIkuCollection::__construct as private __PenilaianIkuCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PenilaianIkuCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $PenilaianIku = PenilaianIku::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PenilaianIkuTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PenilaianIkuTable.name", 'like', '%'.$request->get('name').'%');
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
            // PenilaianIku
            "$this->PenilaianIkuTable.id as pendidikan.id",
            "$this->PenilaianIkuTable.name as pendidikan.name",
            "$this->PenilaianIkuTable.created_at as pendidikan.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $PenilaianIku->orderBy("$this->PenilaianIkuTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $PenilaianIku->orderBy("$this->PenilaianIkuTable.created_at", $request->get('sort_type'));
            } else {
              $PenilaianIku->orderBy("$this->PenilaianIkuTable.created_at", 'desc');
            }
        } else {
            $PenilaianIku->orderBy("$this->PenilaianIkuTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $PenilaianIku, function ($data) use($request) {
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
                $this->Group($item, $key, 'pendidikan.', $item);
            }
            return $item;
        });
    }
}
