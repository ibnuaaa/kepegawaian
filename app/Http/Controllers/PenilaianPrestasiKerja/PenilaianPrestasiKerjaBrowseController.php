<?php

namespace App\Http\Controllers\PenilaianPrestasiKerja;

use App\Models\PenilaianPrestasiKerja;

use App\Traits\Browse;
use App\Traits\PenilaianPrestasiKerja\PenilaianPrestasiKerjaCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PenilaianPrestasiKerjaBrowseController extends Controller
{
    use Browse, PenilaianPrestasiKerjaCollection {
        PenilaianPrestasiKerjaCollection::__construct as private __PenilaianPrestasiKerjaCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PenilaianPrestasiKerjaCollectionConstruct();
    }

    public function get(Request $request)
    {
      
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $PenilaianPrestasiKerja = PenilaianPrestasiKerja::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PenilaianPrestasiKerjaTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PenilaianPrestasiKerjaTable.name", 'like', '%'.$request->get('name').'%');
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
            // PenilaianPrestasiKerja
            "$this->PenilaianPrestasiKerjaTable.id as penilaian_prestasi_kerja.id",
            "$this->PenilaianPrestasiKerjaTable.name as penilaian_prestasi_kerja.name",
            "$this->PenilaianPrestasiKerjaTable.created_at as penilaian_prestasi_kerja.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $PenilaianPrestasiKerja->orderBy("$this->PenilaianPrestasiKerjaTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $PenilaianPrestasiKerja->orderBy("$this->PenilaianPrestasiKerjaTable.created_at", $request->get('sort_type'));
            } else {
              $PenilaianPrestasiKerja->orderBy("$this->PenilaianPrestasiKerjaTable.created_at", 'desc');
            }
        } else {
            $PenilaianPrestasiKerja->orderBy("$this->PenilaianPrestasiKerjaTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $PenilaianPrestasiKerja, function ($data) use($request) {
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
                $this->Group($item, $key, 'penilaian_prestasi_kerja.', $item);
            }
            return $item;
        });
    }
}
