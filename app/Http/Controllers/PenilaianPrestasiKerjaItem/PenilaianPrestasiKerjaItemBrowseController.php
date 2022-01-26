<?php

namespace App\Http\Controllers\PenilaianPrestasiKerjaItem;

use App\Models\PenilaianPrestasiKerjaItem;

use App\Traits\Browse;
use App\Traits\PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PenilaianPrestasiKerjaItemBrowseController extends Controller
{
    use Browse, PenilaianPrestasiKerjaItemCollection {
        PenilaianPrestasiKerjaItemCollection::__construct as private __PenilaianPrestasiKerjaItemCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PenilaianPrestasiKerjaItemCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PenilaianPrestasiKerjaItemTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->penilaian_prestasi_kerja_id)) {
                $query->where("$this->PenilaianPrestasiKerjaItemTable.penilaian_prestasi_kerja_id", $request->ArrQuery->penilaian_prestasi_kerja_id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PenilaianPrestasiKerjaItemTable.name", 'like', '%'.$request->get('name').'%');
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
            // PenilaianPrestasiKerjaItem
            "$this->PenilaianPrestasiKerjaItemTable.id as penilaian_restasi_kerja_item.id",
            "$this->PenilaianPrestasiKerjaItemTable.indikator_kinerja_id as indikator_kinerja_id",
            "$this->PenilaianPrestasiKerjaItemTable.created_at as penilaian_restasi_kerja_item.created_at"
        )->with('indikator_kinerja');

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $PenilaianPrestasiKerjaItem->orderBy("$this->PenilaianPrestasiKerjaItemTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $PenilaianPrestasiKerjaItem->orderBy("$this->PenilaianPrestasiKerjaItemTable.created_at", $request->get('sort_type'));
            } else {
              $PenilaianPrestasiKerjaItem->orderBy("$this->PenilaianPrestasiKerjaItemTable.created_at", 'desc');
            }
        } else {
            $PenilaianPrestasiKerjaItem->orderBy("$this->PenilaianPrestasiKerjaItemTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $PenilaianPrestasiKerjaItem, function ($data) use($request) {
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
                $this->Group($item, $key, 'penilaian_restasi_kerja_item.', $item);
            }
            return $item;
        });
    }
}
