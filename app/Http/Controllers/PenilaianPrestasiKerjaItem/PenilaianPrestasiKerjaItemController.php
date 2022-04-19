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


        // $IndikatorKinerja = IndikatorKinerja::where('id', $Model->PenilaianPrestasiKerjaItem->indikator_kinerja_id)->first();

        // if (!empty($IndikatorKinerja)) {
        //   if ($IndikatorKinerja->tipe_indikator != 'kegiatan') {
        //     $Model->PenilaianPrestasiKerjaItem->bobot = $IndikatorKinerja->bobot;
        //     $Model->PenilaianPrestasiKerjaItem->target = $IndikatorKinerja->target;
        //     $Model->PenilaianPrestasiKerjaItem->realisasi = $IndikatorKinerja->realisasi;
        //     $Model->PenilaianPrestasiKerjaItem->capaian = $IndikatorKinerja->capaian;
        //     $Model->PenilaianPrestasiKerjaItem->nilai_kinerja = $IndikatorKinerja->nilai_kinerja;
        //   }
        // }

        $Model->PenilaianPrestasiKerjaItem->save();

        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerjaItem->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerjaItem->save();

        // $PenilaianPrestasiKerja = PenilaianPrestasiKerja::where('id', $Model->PenilaianPrestasiKerjaItem->penilaian_prestasi_kerja_id)->first();

        // $IndikatorKinerjaKegiatan = IndikatorKinerja::where('id', $Model->PenilaianPrestasiKerjaItem->indikator_kinerja_id)->with('parents')->first();

        // if (!empty($IndikatorKinerjaKegiatan->id)) {
        //   $IndikatorKinerjaAtasan = IndikatorKinerja::where('id' , $IndikatorKinerjaKegiatan->id)->first();
        //   if (!empty($IndikatorKinerjaAtasan)) {
        //       $IndikatorKinerjaAtasan->bobot = $Model->PenilaianPrestasiKerjaItem->bobot;
        //       $IndikatorKinerjaAtasan->target = $Model->PenilaianPrestasiKerjaItem->target;
        //       $IndikatorKinerjaAtasan->realisasi = $Model->PenilaianPrestasiKerjaItem->realisasi;
        //       $IndikatorKinerjaAtasan->capaian = $Model->PenilaianPrestasiKerjaItem->capaian;
        //       $IndikatorKinerjaAtasan->nilai_kinerja = $Model->PenilaianPrestasiKerjaItem->nilai_kinerja;
        //       $IndikatorKinerjaAtasan->save();
        //    }

        //     //  buat direksi & kabag / atasannya kepala ruang &  kasubag
        //     $this->CalculateParentsFromEselon3($IndikatorKinerjaKegiatan);
        // }
        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerjaItem->id));
        return response()->json(Json::get(), 202);
    }

    // public function CalculateParents($IndikatorKinerjaKegiatan, $is_atasan, $PenilaianPrestasiKerja) {
    //
    //
    //     $IndikatorKinerjaProgramSingle = IndikatorKinerja::where('id', $IndikatorKinerjaKegiatan->parent_id)->first();
    //
    //     if (empty($IndikatorKinerjaProgramSingle->parent_id)) {
    //         return false;
    //     }
    //
    //     $indikator_id_iku = $IndikatorKinerjaProgramSingle->parent_id;
    //     // dibawabh iku ada program dan kegiatan apa aja
    //     // mencari semua program atau iku bawahnya
    //     $IndikatorKinerjaProgram = IndikatorKinerja::where('parent_id', $indikator_id_iku)->get();
    //
    //     $dataTotal['bobot'] = 0;
    //     $dataTotal['target'] = 0;
    //     $dataTotal['realisasi'] = 0;
    //     $dataTotal['capaian'] = 0;
    //     $dataTotal['nilai_kinerja'] = 0;
    //
    //     // list program yang dibuat kepala instalasi
    //     foreach ($IndikatorKinerjaProgram as $key => $value) {
    //         // if ($is_atasan) {
    //           // jika atasan
    //           $dataTotalKegiatan = $this->GetPenilaianItemAtasan($value->id);
    //
    //           $dataTotal['bobot'] += $dataTotalKegiatan['bobot'];
    //           $dataTotal['target'] += $dataTotalKegiatan['target'];
    //           $dataTotal['realisasi'] += $dataTotalKegiatan['realisasi'];
    //           $dataTotal['capaian'] += $dataTotalKegiatan['capaian'];
    //           $dataTotal['nilai_kinerja'] += $dataTotalKegiatan['nilai_kinerja'];
    //
    //
    //         // } else {
    //         //   // jika staff
    //         //   // mencari semua kegiatan
    //         //   $IndikatorKinerjaKegiatan = IndikatorKinerja::where('parent_id', $value->id)->get();
    //         //
    //         //   $dataTotalProgram['bobot'] = 0;
    //         //   $dataTotalProgram['target'] = 0;
    //         //   $dataTotalProgram['realisasi'] = 0;
    //         //   $dataTotalProgram['capaian'] = 0;
    //         //   $dataTotalProgram['nilai_kinerja'] = 0;
    //         //
    //         //
    //         //   foreach ($IndikatorKinerjaKegiatan as $key2 => $value2) {
    //         //     // cetak($value2->toArray());
    //         //     $dataTotalKegiatan = $this->GetPenilaianItemAtasan($value2->id);
    //         //
    //         //     $dataTotal['bobot'] += $dataTotalKegiatan['bobot'];
    //         //     $dataTotal['target'] += $dataTotalKegiatan['target'];
    //         //     $dataTotal['realisasi'] += $dataTotalKegiatan['realisasi'];
    //         //     $dataTotal['capaian'] += $dataTotalKegiatan['capaian'];
    //         //     $dataTotal['nilai_kinerja'] += $dataTotalKegiatan['nilai_kinerja'];
    //         //
    //         //     $dataTotalProgram['bobot'] += $dataTotalKegiatan['bobot'];
    //         //     $dataTotalProgram['target'] += $dataTotalKegiatan['target'];
    //         //     $dataTotalProgram['realisasi'] += $dataTotalKegiatan['realisasi'];
    //         //     $dataTotalProgram['capaian'] += $dataTotalKegiatan['capaian'];
    //         //     $dataTotalProgram['nilai_kinerja'] += $dataTotalKegiatan['nilai_kinerja'];
    //         //
    //         //
    //         //   }
    //         //
    //         //   $IndikatorKinerjaAtasan = IndikatorKinerja::where('id' , $value->id)->first();
    //         //
    //         //   cetak($IndikatorKinerjaAtasan->toArray());
    //         //   die();
    //         //
    //         //   if (!empty($IndikatorKinerjaAtasan)) {
    //         //       $IndikatorKinerjaAtasan->bobot = $dataTotalProgram['bobot'];
    //         //       $IndikatorKinerjaAtasan->target = $dataTotalProgram['target'];
    //         //       $IndikatorKinerjaAtasan->realisasi = $dataTotalProgram['realisasi'];
    //         //       if(!empty($dataTotal['target']))  $IndikatorKinerjaAtasan->capaian = $dataTotalProgram['realisasi']/$dataTotalProgram['target'];
    //         //       $IndikatorKinerjaAtasan->nilai_kinerja = $IndikatorKinerjaAtasan->capaian * $dataTotalProgram['bobot'];
    //         //       $IndikatorKinerjaAtasan->save();
    //         //   }
    //         //
    //         //   // die();
    //         // }
    //         //
    //         //
    //         // $IndikatorKinerjaAtasan = IndikatorKinerja::where('id' , $indikator_id_iku)->first();
    //         // if (!empty($IndikatorKinerjaAtasan)) {
    //         //     $IndikatorKinerjaAtasan->bobot = $dataTotal['bobot'];
    //         //     $IndikatorKinerjaAtasan->target = $dataTotal['target'];
    //         //     $IndikatorKinerjaAtasan->realisasi = $dataTotal['realisasi'];
    //         //     if(!empty($dataTotal['target']))  $IndikatorKinerjaAtasan->capaian = $dataTotal['realisasi']/$dataTotal['target'];
    //         //     $IndikatorKinerjaAtasan->nilai_kinerja = $IndikatorKinerjaAtasan->capaian * $dataTotal['bobot'];
    //         //     $IndikatorKinerjaAtasan->save();
    //         // }
    //
    //
    //
    //     }
    //
    //     // indikator atasan buat diupdate
    //     $PenilaianPrestasiKerjaItemAtasan = PenilaianPrestasiKerjaItem::select(
    //                                             'penilaian_prestasi_kerja_item.id as id'
    //                                         )
    //                                         ->leftJoin('indikator_kinerja', 'indikator_kinerja.id', '=', 'penilaian_prestasi_kerja_item.indikator_kinerja_id')
    //                                         ->leftJoin('penilaian_prestasi_kerja', 'penilaian_prestasi_kerja.id', '=', 'penilaian_prestasi_kerja_item.penilaian_prestasi_kerja_id')
    //                                         ->where('indikator_kinerja_id' , $indikator_id_iku)
    //                                         ->whereNull('indikator_kinerja.deleted_at')
    //                                         ->whereNull('penilaian_prestasi_kerja_item.deleted_at')
    //                                         ->whereNull('penilaian_prestasi_kerja.deleted_at')
    //                                         ->first();
    //
    //     if (!empty($PenilaianPrestasiKerjaItemAtasan)) {
    //         $PenilaianPrestasiKerjaItemAtasanUpdate = PenilaianPrestasiKerjaItem::where('id' , $PenilaianPrestasiKerjaItemAtasan->id)->first();
    //         $PenilaianPrestasiKerjaItemAtasanUpdate->bobot = $dataTotal['bobot'];
    //         $PenilaianPrestasiKerjaItemAtasanUpdate->target = $dataTotal['target'];
    //         $PenilaianPrestasiKerjaItemAtasanUpdate->realisasi = $dataTotal['realisasi'];
    //         if (!empty($dataTotal['target'])) $PenilaianPrestasiKerjaItemAtasanUpdate->capaian = $dataTotal['realisasi']/$dataTotal['target'];
    //         $PenilaianPrestasiKerjaItemAtasanUpdate->nilai_kinerja = $PenilaianPrestasiKerjaItemAtasanUpdate->capaian * $dataTotal['bobot'];
    //         $PenilaianPrestasiKerjaItemAtasanUpdate->save();
    //     }
    //
    //
    //
    //     if (!empty($IndikatorKinerjaProgram->parents)) $this->CalculateParents($IndikatorKinerjaProgram->parents, 1, $PenilaianPrestasiKerja);
    // }



    public function CalculateParentsFromEselon3($IndikatorKinerjaProgram) {

        // cetak();
        // die();

        if ($IndikatorKinerjaProgram->tipe_indikator == 'kegiatan') {
              $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::select(
                                                  'penilaian_prestasi_kerja_item.id as id',
                                                  'penilaian_prestasi_kerja_item.bobot as  bobot',
                                                  'penilaian_prestasi_kerja_item.target as  target',
                                                  'penilaian_prestasi_kerja_item.realisasi as  realisasi',
                                                  'penilaian_prestasi_kerja_item.capaian as  capaian',
                                                  'penilaian_prestasi_kerja_item.nilai_kinerja as  nilai_kinerja'
                                              )
                                              ->leftJoin('indikator_kinerja', 'indikator_kinerja.id', '=', 'penilaian_prestasi_kerja_item.indikator_kinerja_id')
                                              ->leftJoin('penilaian_prestasi_kerja', 'penilaian_prestasi_kerja.id', '=', 'penilaian_prestasi_kerja_item.penilaian_prestasi_kerja_id')
                                              ->where('indikator_kinerja_id' , $IndikatorKinerjaProgram->id)
                                              ->whereNull('indikator_kinerja.deleted_at')
                                              ->whereNull('penilaian_prestasi_kerja_item.deleted_at')
                                              ->whereNull('penilaian_prestasi_kerja.deleted_at')
                                              ->get();
              if ($PenilaianPrestasiKerjaItem) {
                  $bobot = 0;
                  $target = 0;
                  $realisasi = 0;
                  $capaian = 0;
                  $nilai_kinerja = 0;

                  foreach ($PenilaianPrestasiKerjaItem as $key => $value) {
                    $bobot += $value->bobot;
                    $target += $value->target;
                    $realisasi += $value->realisasi;
                    $capaian += $value->capaian;
                    $nilai_kinerja += $value->nilai_kinerja;
                  }
              }

              $IndikatorKinerja = IndikatorKinerja::where('id', $IndikatorKinerjaProgram->id)->first();
              if ($IndikatorKinerja) {
                $IndikatorKinerja->bobot = $bobot;
                $IndikatorKinerja->target = $target;
                $IndikatorKinerja->realisasi = $realisasi;
                $IndikatorKinerja->capaian = $capaian;
                $IndikatorKinerja->nilai_kinerja = $nilai_kinerja;
                $IndikatorKinerja->save();
              }
        }

        $IndikatorKinerjaSeLevel = IndikatorKinerja::where('parent_id', $IndikatorKinerjaProgram->parent_id)->get();

        $dataTotal['bobot'] = 0;
        $dataTotal['target'] = 0;
        $dataTotal['realisasi'] = 0;
        $dataTotal['capaian'] = 0;
        $dataTotal['nilai_kinerja'] = 0;

        foreach ($IndikatorKinerjaSeLevel as $key => $value) {


            $dataTotal['bobot'] += $value->bobot;
            $dataTotal['target'] += $value->target;
            $dataTotal['realisasi'] += $value->realisasi;
            $dataTotal['capaian'] += $value->capaian;
            $dataTotal['nilai_kinerja'] += $value->nilai_kinerja;
        }



        if ($IndikatorKinerjaProgram->id == 77) {
          // cetak($IndikatorKinerjaSeLevel->toArray());
          // cetak($dataTotal);
          // die();
        }


        // indikator atasan buat diupdate
        $PenilaianPrestasiKerjaItemAtasan = PenilaianPrestasiKerjaItem::select(
                                                'penilaian_prestasi_kerja_item.id as id'
                                            )
                                            ->leftJoin('indikator_kinerja', 'indikator_kinerja.id', '=', 'penilaian_prestasi_kerja_item.indikator_kinerja_id')
                                            ->leftJoin('penilaian_prestasi_kerja', 'penilaian_prestasi_kerja.id', '=', 'penilaian_prestasi_kerja_item.penilaian_prestasi_kerja_id')
                                            ->where('indikator_kinerja_id' , $IndikatorKinerjaProgram->parent_id)
                                            ->whereNull('indikator_kinerja.deleted_at')
                                            ->whereNull('penilaian_prestasi_kerja_item.deleted_at')
                                            ->whereNull('penilaian_prestasi_kerja.deleted_at')
                                            ->first();



        if (!empty($PenilaianPrestasiKerjaItemAtasan)) {
            $PenilaianPrestasiKerjaItemAtasanUpdate = PenilaianPrestasiKerjaItem::where('id' , $PenilaianPrestasiKerjaItemAtasan->id)->first();
            $PenilaianPrestasiKerjaItemAtasanUpdate->bobot = $dataTotal['bobot'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->target = $dataTotal['target'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->realisasi = $dataTotal['realisasi'];
            if(!empty($dataTotal['target'])) $PenilaianPrestasiKerjaItemAtasanUpdate->capaian = $dataTotal['realisasi']/$dataTotal['target'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->nilai_kinerja = $PenilaianPrestasiKerjaItemAtasanUpdate->capaian * $dataTotal['bobot'];
            $PenilaianPrestasiKerjaItemAtasanUpdate->save();
        }

        $IndikatorKinerjaAtasan = IndikatorKinerja::where('id' , $IndikatorKinerjaProgram->parent_id)->first();
        if (!empty($IndikatorKinerjaAtasan)) {
            $IndikatorKinerjaAtasan->bobot = $dataTotal['bobot'];
            $IndikatorKinerjaAtasan->target = $dataTotal['target'];
            $IndikatorKinerjaAtasan->realisasi = $dataTotal['realisasi'];
            if(!empty($dataTotal['target']))  $IndikatorKinerjaAtasan->capaian = $dataTotal['realisasi']/$dataTotal['target'];
            $IndikatorKinerjaAtasan->nilai_kinerja = $IndikatorKinerjaAtasan->capaian * $dataTotal['bobot'];
            $IndikatorKinerjaAtasan->save();
        }



        if (!empty($IndikatorKinerjaProgram->parents)) $this->CalculateParentsFromEselon3($IndikatorKinerjaProgram->parents);
    }

    // public function GetPenilaianItemAtasan($id) {
    //
    //
    //   $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::leftJoin('indikator_kinerja', 'indikator_kinerja.id', '=', 'penilaian_prestasi_kerja_item.indikator_kinerja_id')
    //                                   ->select(
    //                                     'penilaian_prestasi_kerja_item.bobot',
    //                                     'penilaian_prestasi_kerja_item.target',
    //                                     'penilaian_prestasi_kerja_item.realisasi',
    //                                     'penilaian_prestasi_kerja_item.capaian',
    //                                     'penilaian_prestasi_kerja_item.nilai_kinerja'
    //                                   )
    //                                   ->leftJoin('penilaian_prestasi_kerja', 'penilaian_prestasi_kerja.id', '=', 'penilaian_prestasi_kerja_item.penilaian_prestasi_kerja_id')
    //                                   ->where('indikator_kinerja_id' , $id)
    //                                   ->whereNull('indikator_kinerja.deleted_at')
    //                                   ->whereNull('penilaian_prestasi_kerja_item.deleted_at')
    //                                   ->whereNull('penilaian_prestasi_kerja.deleted_at')
    //                                   ->get();
    //
    //   $dataTotal['bobot'] = 0;
    //   $dataTotal['target'] = 0;
    //   $dataTotal['realisasi'] = 0;
    //   $dataTotal['capaian'] = 0;
    //   $dataTotal['nilai_kinerja'] = 0;
    //
    //   foreach ($PenilaianPrestasiKerjaItem as $key => $value) {
    //       $dataTotal['bobot'] = $value->bobot;
    //       $dataTotal['target'] = $value->target;
    //       $dataTotal['realisasi'] = $value->realisasi;
    //       $dataTotal['capaian'] = $value->capaian;
    //       $dataTotal['nilai_kinerja'] = $value->nilai_kinerja;
    //   }
    //
    //   return $dataTotal;
    //
    // }

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
