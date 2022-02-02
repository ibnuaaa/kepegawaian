<?php

namespace App\Http\Controllers\PenilaianPrestasiKerjaItem;

use App\Models\PenilaianPrestasiKerjaItem;
use App\Models\PenilaianPrestasiKerja;
use App\Models\IndikatorKinerja;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PenilaianPrestasiKerjaItemController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'code',
        'name'
    ];
    public function get(Request $request)
    {
        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where(function ($query) use($request) {
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
        $Browse = $this->Browse($request, $PenilaianPrestasiKerjaItem, function ($data) use($request) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerjaItem->save();

        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerjaItem->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerjaItem->save();

        $IndikatorKinerjaProgram = IndikatorKinerja::where('id', $Model->PenilaianPrestasiKerjaItem->indikator_kinerja_id)->with('parents')->first();

        if (!empty($IndikatorKinerjaProgram->tipe_indikator) && $IndikatorKinerjaProgram->tipe_indikator == 'kegiatan') {
            // Get parent_id Indikator






            //  buat direksi & kabag / atasannya kepala ruang &  kasubag

            $this->CalculateParents($IndikatorKinerjaProgram, 0);



        }

        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerjaItem->id));
        return response()->json(Json::get(), 202);
    }

    public function CalculateParents($IndikatorKinerjaProgram, $is_atasan) {

        $IndikatorKinerjaIku = IndikatorKinerja::where('id', $IndikatorKinerjaProgram->parent_id)->first();

        if (empty($IndikatorKinerjaIku->parent_id)) {
            return false;
        }

        $indikator_id_iku = $IndikatorKinerjaIku->parent_id;



        // dibawabh iku ada program dan kegiatan apa aja
        // mencari semua .program
        $IndikatorKinerjaIkuChild = IndikatorKinerja::where('parent_id', $indikator_id_iku)->get();

        $dataTotal['bobot'] = 0;
        $dataTotal['target'] = 0;
        $dataTotal['realisasi'] = 0;
        $dataTotal['capaian'] = 0;
        $dataTotal['nilai_kinerja'] = 0;

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


        if (!empty($PenilaianPrestasiKerjaItemAtasan)) {
            $PenilaianPrestasiKerjaItemAtasanUpdate = PenilaianPrestasiKerjaItem::where('id' , $PenilaianPrestasiKerjaItemAtasan->id)->first();
            $PenilaianPrestasiKerjaItemAtasanUpdate->bobot = $dataTotal['bobot'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->target = $dataTotal['target'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->realisasi = $dataTotal['realisasi'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->capaian = $dataTotal['realisasi']/$dataTotal['target'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->nilai_kinerja = $PenilaianPrestasiKerjaItemAtasanUpdate->capaian * $dataTotal['bobot'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->save();
        }

        if (!empty($IndikatorKinerjaProgram->parents)) $this->CalculateParents($IndikatorKinerjaProgram->parents, 1);
    }

    public function GetPenilaianItemAtasan($id, $dataTotal) {


      $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::leftJoin('indikator_kinerja', 'indikator_kinerja.id', '=', 'penilaian_prestasi_kerja_item.indikator_kinerja_id')
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
        $Model->PenilaianPrestasiKerjaItem->delete();
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
