<?php

namespace App\Http\Controllers\StatusPegawai;

use App\Models\StatusPegawai;

use App\Traits\Browse;
use App\Traits\StatusPegawai\StatusPegawaiCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class StatusPegawaiBrowseController extends Controller
{
    use Browse, StatusPegawaiCollection {
        StatusPegawaiCollection::__construct as private __StatusPegawaiCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__StatusPegawaiCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $StatusPegawai = StatusPegawai::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->StatusPegawaiTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->StatusPegawaiTable.name", 'like', '%'.$request->get('name').'%');
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
            // StatusPegawai
            "$this->StatusPegawaiTable.id as status_pegawai.id",
            "$this->StatusPegawaiTable.name as status_pegawai.name",
            "$this->StatusPegawaiTable.created_at as status_pegawai.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $StatusPegawai->orderBy("$this->StatusPegawaiTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $StatusPegawai->orderBy("$this->StatusPegawaiTable.created_at", $request->get('sort_type'));
            } else {
              $StatusPegawai->orderBy("$this->StatusPegawaiTable.created_at", 'desc');
            }
        } else {
            $StatusPegawai->orderBy("$this->StatusPegawaiTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $StatusPegawai, function ($data) use($request) {
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
                $this->Group($item, $key, 'status_pegawai.', $item);
            }
            return $item;
        });
    }
}
