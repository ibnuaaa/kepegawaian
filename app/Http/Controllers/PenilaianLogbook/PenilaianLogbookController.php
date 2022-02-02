<?php

namespace App\Http\Controllers\PenilaianLogbook;

use App\Models\PenilaianLogbook;
use App\Models\PenilaianPrestasiKerja;
use App\Models\PenilaianPrestasiKerjaItem;
use App\Models\IndikatorKinerja;


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



        if ($PenilaianPrestasiKerjaItem->bobot && $PenilaianPrestasiKerjaItem->target && $PenilaianPrestasiKerjaItem->realisasi) {

            $bobot = $PenilaianPrestasiKerjaItem->bobot;
            $target = $PenilaianPrestasiKerjaItem->target;
            $realisasi = $PenilaianPrestasiKerjaItem->realisasi;

            $capaian = $realisasi / $target;
            $nilai_kinerja = $capaian * $bobot;

            $PenilaianPrestasiKerjaItem->capaian = $capaian;
            $PenilaianPrestasiKerjaItem->nilai_kinerja = $nilai_kinerja;

        }

        $PenilaianPrestasiKerjaItem->save();

        $this->updateLogbookKegiatan($PenilaianPrestasiKerjaItem->indikator_kinerja_id);

        Json::set('data', [
            'detail' => $this->SyncData($request, $Model->PenilaianLogbook->id),
            'total' => $total
        ]);

        return response()->json(Json::get(), 202);
    }


    public function updateLogbookKegiatan($indikator_kinerja_id) {
      $IndikatorKinerjaProgram = IndikatorKinerja::where('id', $indikator_kinerja_id)->with('parents')->first();

      if (!empty($IndikatorKinerjaProgram->tipe_indikator) && $IndikatorKinerjaProgram->tipe_indikator == 'kegiatan') {
          //  buat direksi & kabag / atasannya kepala ruang &  kasubag
          $this->CalculateParents($IndikatorKinerjaProgram, 0);
      }
    }

    public function CalculateParents($IndikatorKinerjaProgram, $is_atasan) {

        $IndikatorKinerjaIku = IndikatorKinerja::where('id', $IndikatorKinerjaProgram->parent_id)->first();

        if (empty($IndikatorKinerjaIku->parent_id)) {
            return false;
        }

        $indikator_id_iku = $IndikatorKinerjaIku->parent_id;

        // dibawabh iku ada program dan kegiatan apa aja
        // mencari semua program atau iku bawahnya
        $IndikatorKinerjaIkuChild = IndikatorKinerja::where('parent_id', $indikator_id_iku)->get();

        $dataTotal['bobot'] = 0;
        $dataTotal['target'] = 0;
        $dataTotal['realisasi'] = 0;
        $dataTotal['capaian'] = 0;
        $dataTotal['nilai_kinerja'] = 0;

        // list program yang dibuat kepala instalasi
        foreach ($IndikatorKinerjaIkuChild as $key => $value) {
            if ($is_atasan) {
              $dataTotal = $this->GetPenilaianItemAtasan($value->id, $dataTotal);
            } else {
              // mencari semua kegiatan
              $IndikatorKinerjaKegiatan = IndikatorKinerja::where('parent_id', $value->id)->get();
              foreach ($IndikatorKinerjaKegiatan as $key2 => $value2) {
                $dataTotal = $this->GetPenilaianItemAtasan($value2->id, $dataTotal);
              }
            }

        }

        // indikator atasan buat diupdate
        $PenilaianPrestasiKerjaItemAtasan = PenilaianPrestasiKerjaItem::select(
                                                'penilaian_prestasi_kerja_item.id as id'
                                            )
                                            ->leftJoin('indikator_kinerja', 'indikator_kinerja.id', '=', 'penilaian_prestasi_kerja_item.indikator_kinerja_id')
                                            ->leftJoin('penilaian_prestasi_kerja', 'penilaian_prestasi_kerja.id', '=', 'penilaian_prestasi_kerja_item.penilaian_prestasi_kerja_id')
                                            ->where('indikator_kinerja_id' , $indikator_id_iku)
                                            ->whereNull('indikator_kinerja.deleted_at')
                                            ->whereNull('penilaian_prestasi_kerja_item.deleted_at')
                                            ->whereNull('penilaian_prestasi_kerja.deleted_at')
                                            ->first();
        $bobot = $dataTotal['bobot'];
        $target = $dataTotal['target'];
        $realisasi = $dataTotal['realisasi'];
        $capaian = 0;
        if (!empty($dataTotal['target'])) $capaian = $dataTotal['realisasi']/$dataTotal['target'];
        $nilai_kinerja = $capaian * $dataTotal['bobot'];

        if (!empty($PenilaianPrestasiKerjaItemAtasan)) {
            $PenilaianPrestasiKerjaItemAtasanUpdate = PenilaianPrestasiKerjaItem::where('id' , $PenilaianPrestasiKerjaItemAtasan->id)->first();
            $PenilaianPrestasiKerjaItemAtasanUpdate->bobot = $bobot;
            $PenilaianPrestasiKerjaItemAtasanUpdate->target = $target;
            $PenilaianPrestasiKerjaItemAtasanUpdate->realisasi = $realisasi;
            $PenilaianPrestasiKerjaItemAtasanUpdate->capaian = $capaian;
            $PenilaianPrestasiKerjaItemAtasanUpdate->nilai_kinerja = $nilai_kinerja;
            $PenilaianPrestasiKerjaItemAtasanUpdate->save();
        }

        $IndikatorKinerjaAtasan = IndikatorKinerja::where('id' , $indikator_id_iku)->first();
        if (!empty($IndikatorKinerjaAtasan)) {
            $IndikatorKinerjaAtasan->bobot = $bobot;
            $IndikatorKinerjaAtasan->target = $target;
            $IndikatorKinerjaAtasan->realisasi = $realisasi;
            $IndikatorKinerjaAtasan->capaian = $capaian;
            $IndikatorKinerjaAtasan->nilai_kinerja = $nilai_kinerja;
            $IndikatorKinerjaAtasan->save();
        }

        if (!empty($IndikatorKinerjaProgram->parents)) $this->CalculateParents($IndikatorKinerjaProgram->parents, 1);
    }

    public function GetPenilaianItemAtasan($id, $dataTotal) {


      $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::leftJoin('indikator_kinerja', 'indikator_kinerja.id', '=', 'penilaian_prestasi_kerja_item.indikator_kinerja_id')
                                      ->select(
                                        'penilaian_prestasi_kerja_item.bobot',
                                        'penilaian_prestasi_kerja_item.target',
                                        'penilaian_prestasi_kerja_item.realisasi',
                                        'penilaian_prestasi_kerja_item.capaian',
                                        'penilaian_prestasi_kerja_item.nilai_kinerja'
                                      )
                                      ->leftJoin('penilaian_prestasi_kerja', 'penilaian_prestasi_kerja.id', '=', 'penilaian_prestasi_kerja_item.penilaian_prestasi_kerja_id')
                                      ->where('indikator_kinerja_id' , $id)
                                      ->whereNull('indikator_kinerja.deleted_at')
                                      ->whereNull('penilaian_prestasi_kerja_item.deleted_at')
                                      ->whereNull('penilaian_prestasi_kerja.deleted_at')
                                      ->get();
      foreach ($PenilaianPrestasiKerjaItem as $key => $value) {
          $dataTotal['bobot'] += $value->bobot;
          $dataTotal['target'] += $value->target;
          $dataTotal['realisasi'] += $value->realisasi;
          $dataTotal['capaian'] += $value->capaian;
          $dataTotal['nilai_kinerja'] += $value->nilai_kinerja;
      }

      return $dataTotal;

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
