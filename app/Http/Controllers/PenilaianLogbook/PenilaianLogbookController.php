<?php

namespace App\Http\Controllers\PenilaianLogbook;

use App\Models\PenilaianLogbook;
use App\Models\PenilaianPrestasiKerja;
use App\Models\PenilaianPrestasiKerjaItem;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PenilaianLogbookController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'code',
        'name'
    ];
    public function get(Request $request)
    {
        $PenilaianLogbook = PenilaianLogbook::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->information()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                  $query->where('code', 'like', $search);
                  $query->orWhere('name', 'like', $search);
               } else {
                   $query->where(function ($query) use($search) {
                       foreach ($this->search as $key => $value) {
                           $query->orWhere($value, 'like', $search);
                       }
                   });
               }
           }
        });
        $Browse = $this->Browse($request, $PenilaianLogbook, function ($data) use($request) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianLogbook->save();

        Json::set('data', $this->SyncData($request, $Model->PenilaianLogbook->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianLogbook->save();

        $PenilaianLogbook = PenilaianLogbook::where('indikator_kinerja_id',  $Model->PenilaianLogbook->indikator_kinerja_id)
            ->where('penilaian_prestasi_kerja_id',  $Model->PenilaianLogbook->penilaian_prestasi_kerja_id)
            ->get();

        $PenilaianPrestasiKerja = PenilaianPrestasiKerja::where('id',$Model->PenilaianLogbook->penilaian_prestasi_kerja_id)->first();

        $num_days = cal_days_in_month(CAL_GREGORIAN, $PenilaianPrestasiKerja->bulan, $PenilaianPrestasiKerja->tahun);

        $nilai = [];
        foreach ($PenilaianLogbook as $key => $value) {
          $nilai[$value->tanggal] = floatval($value->nilai);
        }

        $total = 0;
        for ($tanggal=1; $tanggal <= $num_days; $tanggal++) {
          if (!empty($nilai[$tanggal])) $total += $nilai[$tanggal];
        }

        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('indikator_kinerja_id', $Model->PenilaianLogbook->indikator_kinerja_id)
            ->where('indikator_kinerja_id', $Model->PenilaianLogbook->indikator_kinerja_id)
            ->where('penilaian_prestasi_kerja_id', $Model->PenilaianLogbook->penilaian_prestasi_kerja_id)
            ->first();
        $PenilaianPrestasiKerjaItem->realisasi = $total;
        $PenilaianPrestasiKerjaItem->save();

        Json::set('data', [
            'detail' => $this->SyncData($request, $Model->PenilaianLogbook->id),
            'total' => $total
        ]);

        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianLogbook->delete();
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->get($QueryRoute);
        return $data->original['data']['records'];
    }
}
