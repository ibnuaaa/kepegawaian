<?php

namespace App\Http\Controllers\PenilaianLogbook;

use App\Models\PenilaianLogbook;

use App\Traits\Browse;
use App\Traits\PenilaianLogbook\PenilaianLogbookCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PenilaianLogbookBrowseController extends Controller
{
    use Browse, PenilaianLogbookCollection {
        PenilaianLogbookCollection::__construct as private __PenilaianLogbookCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PenilaianLogbookCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $PenilaianLogbook = PenilaianLogbook::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PenilaianLogbookTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->penilaian_prestasi_kerja_id)) {
                $query->where("$this->PenilaianLogbookTable.penilaian_prestasi_kerja_id", $request->ArrQuery->penilaian_prestasi_kerja_id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PenilaianLogbookTable.name", 'like', '%'.$request->get('name').'%');
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
            // PenilaianLogbook
            "$this->PenilaianLogbookTable.id as id",
            "$this->PenilaianLogbookTable.tanggal as tanggal",
            "$this->PenilaianLogbookTable.nilai as nilai",
            "$this->PenilaianLogbookTable.penilaian_prestasi_kerja_id as penilaian_prestasi_kerja_id",
            "$this->PenilaianLogbookTable.indikator_kinerja_id as indikator_kinerja_id",
            "$this->PenilaianLogbookTable.created_at as created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $PenilaianLogbook->orderBy("$this->PenilaianLogbookTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $PenilaianLogbook->orderBy("$this->PenilaianLogbookTable.created_at", $request->get('sort_type'));
            } else {
              $PenilaianLogbook->orderBy("$this->PenilaianLogbookTable.created_at", 'desc');
            }
        } else {
            $PenilaianLogbook->orderBy("$this->PenilaianLogbookTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $PenilaianLogbook, function ($data) use($request) {
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
                $this->Group($item, $key, 'penilaian_logbook.', $item);
            }
            return $item;
        });
    }
}
