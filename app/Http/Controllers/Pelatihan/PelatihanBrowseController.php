<?php

namespace App\Http\Controllers\Pelatihan;

use App\Models\Pelatihan;

use App\Traits\Browse;
use App\Traits\Pelatihan\PelatihanCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class PelatihanBrowseController extends Controller
{
    use Browse, PelatihanCollection {
        PelatihanCollection::__construct as private __PelatihanCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PelatihanCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Pelatihan = Pelatihan::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PelatihanTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->PelatihanTable.name", 'like', '%'.$request->get('name').'%');
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
            // Pelatihan
            "$this->PelatihanTable.id as pelatihan.id",
            "$this->PelatihanTable.name as pelatihan.name",
            "$this->PelatihanTable.description as pelatihan.description",
            "$this->PelatihanTable.tanggal_mulai_pendaftaran as pelatihan.tanggal_mulai_pendaftaran",
            "$this->PelatihanTable.tanggal_selesai_pendaftaran as pelatihan.tanggal_selesai_pendaftaran",
            "$this->PelatihanTable.tanggal_mulai_pelatihan as pelatihan.tanggal_mulai_pelatihan",
            "$this->PelatihanTable.tanggal_selesai_pelatihan as pelatihan.tanggal_selesai_pelatihan",
            "$this->PelatihanTable.created_at as pelatihan.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $Pelatihan->orderBy("$this->PelatihanTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $Pelatihan->orderBy("$this->PelatihanTable.created_at", $request->get('sort_type'));
            } else {
              $Pelatihan->orderBy("$this->PelatihanTable.created_at", 'desc');
            }
        } else {
            $Pelatihan->orderBy("$this->PelatihanTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $Pelatihan, function ($data) use($request) {
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
                $this->Group($item, $key, 'pelatihan.', $item);
            }
            return $item;
        });
    }
}
