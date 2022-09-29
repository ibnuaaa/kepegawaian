<?php

namespace App\Http\Controllers\CMS\PenilaianPrestasiKerja;

use App\Http\Controllers\PenilaianPrestasiKerja\PenilaianPrestasiKerjaBrowseController;
use App\Http\Controllers\IndikatorKinerja\IndikatorKinerjaBrowseController;
use App\Http\Controllers\PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemBrowseController;
use App\Http\Controllers\PenilaianPrestasiKerjaApproval\PenilaianPrestasiKerjaApprovalBrowseController;

use App\Http\Controllers\PenilaianLogbook\PenilaianLogbookBrowseController;

use App\Http\Controllers\Jabatan\JabatanBrowseController;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Models\IndikatorKinerja;
use App\Models\IndikatorTetap;
use App\Models\UnitKerja;
use App\Models\Jabatan;
use App\Models\User;
use App\Models\UploadAbsensi;
use App\Models\UploadAbsensiDetail;
use App\Models\PenilaianPrestasiKerjaItem;
use App\Models\PenilaianPrestasiKerja;

use App\Models\PenilaianIku;


use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade as PDF;

class PenilaianPrestasiKerjaController extends Controller
{


    public function IndikatorSkp(Request $request, $penilaian_prestasi_kerja_id)
    {
        $TableKey = 'indikator_skp-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['indikator_skp-table-show'])) {
            $selected = $request['indikator_skp-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItemBrowseController::FetchBrowse($request)
            ->where('type', 'skp')
            ->where('penilaian_prestasi_kerja_id', $penilaian_prestasi_kerja_id)
            ->where('with.total', 'true')
            ;

        if (isset($filter_search)) {
            $IndikatorSkp = $IndikatorSkp->where('search', $filter_search);
        }

        $PenilaianPrestasiKerjaItem = $PenilaianPrestasiKerjaItem->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');



        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$PenilaianPrestasiKerjaItem['total'], (int)$PenilaianPrestasiKerjaItem['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Indikator Kinerja'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($PenilaianPrestasiKerjaItem['records']) {
            $DataTable['records'] = $PenilaianPrestasiKerjaItem['records'];
            $DataTable['total'] = $PenilaianPrestasiKerjaItem['total'];
            $DataTable['show'] = $PenilaianPrestasiKerjaItem['show'];
        }



        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0,
            'penilaian_prestasi_kerja_id' => $penilaian_prestasi_kerja_id
        ];


        return view('app.penilaian_prestasi_kerja.indikator_skp.index', $ParseData);
    }


    public function Home(Request $request)
    {
        $TableKey = 'penilaian_prestasi_kerja-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['penilaian_prestasi_kerja-table-show'])) {
            $selected = $request['penilaian_prestasi_kerja-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('user_id',  MyAccount()->id)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->where('search', $filter_search);
        }

        $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');

        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$PenilaianPrestasiKerja['total'], (int)$PenilaianPrestasiKerja['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'bulan', 'label' => 'Bulan - Tahun'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'catatan', 'label' => 'Catatan'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($PenilaianPrestasiKerja['records']) {
            $DataTable['records'] = $PenilaianPrestasiKerja['records'];
            $DataTable['total'] = $PenilaianPrestasiKerja['total'];
            $DataTable['show'] = $PenilaianPrestasiKerja['show'];
        }


        // Get detail jabatan apakah dia staff atau bukan
        $Jabatan = JabatanBrowseController::FetchBrowse($request)
                    ->equal('id', MyAccount()->jabatan_id)->get('first');

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0,
            'jabatan' => $Jabatan['records'],
        ];
        return view('app.penilaian_prestasi_kerja.home.index', $ParseData);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $PenilaianPrestasiKerjaBrowseController = new PenilaianPrestasiKerjaBrowseController($QueryRoute);
        $data = $PenilaianPrestasiKerjaBrowseController->get($QueryRoute);

        return view('app.penilaian_prestasi_kerja.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Logbook(Request $request, $id)
    {
        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)
            ->get('first');

        $num_days = cal_days_in_month(CAL_GREGORIAN, $PenilaianPrestasiKerja['records']->bulan, $PenilaianPrestasiKerja['records']->tahun);

        $PenilaianLogbook = PenilaianLogbookBrowseController::FetchBrowse($request)
            ->where('penilaian_prestasi_kerja_id', $id)
            ->where('take', '100000')
            ->get();

        $nilai = [];
        foreach ($PenilaianLogbook['records'] as $key => $value) {
            $nilai[$value->indikator_kinerja_id][$value->tanggal] = floatval($value->nilai);
        }

        return view('app.penilaian_prestasi_kerja.logbook.index', [
          'data' => $PenilaianPrestasiKerja['records'],
          'num_days' => $num_days,
          'nilai' => $nilai
        ]);
    }



    public function Edit(Request $request, $id)
    {
        $PenilaianPrestasiKerja = PenilaianPrestasiKerja::where('id', $id)->with('user')->with('penilaian_prestasi_kerja_item')->first();

        $bulan = $PenilaianPrestasiKerja->bulan;
        $tahun = $PenilaianPrestasiKerja->tahun;


        $realisasi = [];

        foreach ($PenilaianPrestasiKerja->penilaian_prestasi_kerja_item as $key => $value) {
            $IndikatorKinerjaSingle = IndikatorKinerja::where('id', $value->indikator_kinerja_id)->first();
            $IndikatorKinerja = IndikatorKinerja::where('parent_id', $value->indikator_kinerja_id)->get();

            if ($IndikatorKinerjaSingle->tipe_indikator != 'kegiatan') {

                $total_persentase_0 = 0;
                $jml_persentase_0 = 0;
                $rata0 = 0;

                foreach ($IndikatorKinerja as $key1 => $value1) {

                    $total_persentase_1 = 0;
                    $jml_persentase_1 = 0;
                    $rata1 = 0;


                    if($value1->tipe_indikator == 'kegiatan') {

                      // $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('indikator_kinerja_id', $value1->id)->with('penilaian_prestasi_kerja')
                      //     ->where(function ($query) use($request,$bulan,$tahun) {
                      //         $query->whereHas("penilaian_prestasi_kerja", function ($query) use($request,$bulan,$tahun) {
                      //             $query->where('bulan',$bulan);
                      //             $query->where('tahun',$tahun);
                      //         });
                      //     })->get();
                      // $total_persentase_iki = 0;
                      // $jml_persentase_iki = 0;
                      // $rataiki = 0;
                      // foreach ($PenilaianPrestasiKerjaItem as $keyitem => $item) {
                      //     // hitung total realisasi dalam persen
                      //     $jml_persentase_iki++;
                      //     $persentase = ($item->realisasi_approved / $item->target) * 100;
                      //     $total_persentase_iki += $persentase;
                      //
                      // }
                      //
                      // if($jml_persentase_iki && $total_persentase_iki) $rataiki = $total_persentase_iki / $jml_persentase_iki;

                      $ratarata = $this->getIkiBerdasarIkiBulanTahun($request, $value1->id, $bulan, $tahun);

                      // cetak('level-1-keg' . ' - ' .  $value1->id. ' - ' .$rataiki);

                      $realisasi_item['indikator_kinerja'] = $value1;
                      $realisasi_item['value'] = $ratarata['rataiki'];
                      $realisasi_item['level'] = 1;
                      $realisasi[] = $realisasi_item;

                      if($ratarata['jml_persentase_iki']) $jml_persentase_0++;


                      $total_persentase_0 += $ratarata['rataiki'];



                    } else {
                        $IndikatorKinerja = IndikatorKinerja::where('parent_id', $value1->id)->get();

                        foreach ($IndikatorKinerja as $key2 => $value2) {
                            if ($value2->tipe_indikator == 'kegiatan') {

                                // $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('indikator_kinerja_id', $value2->id)->with('penilaian_prestasi_kerja')
                                //     ->where(function ($query) use($request,$bulan,$tahun) {
                                //         $query->whereHas("penilaian_prestasi_kerja", function ($query) use($request,$bulan,$tahun) {
                                //             $query->where('bulan',$bulan);
                                //             $query->where('tahun',$tahun);
                                //         });
                                //     })->get();
                                // $total_persentase_iki = 0;
                                // $jml_persentase_iki = 0;
                                // $rataiki = 0;
                                // foreach ($PenilaianPrestasiKerjaItem as $keyitem => $item) {
                                //     // hitung total realisasi dalam persen
                                //     $jml_persentase_iki++;
                                //     $persentase = ($item->realisasi_approved / $item->target) * 100;
                                //     $total_persentase_iki += $persentase;
                                // }
                                //
                                // if($jml_persentase_iki && $total_persentase_iki) $rataiki = $total_persentase_iki / $jml_persentase_iki;
                                $ratarata = $this->getIkiBerdasarIkiBulanTahun($request, $value2->id, $bulan, $tahun);
                                // cetak('level-2-keg' . ' - ' .  $value2->id. ' - ' .$rataiki);

                                $realisasi_item['indikator_kinerja'] = $value2;
                                $realisasi_item['value'] = $ratarata['rataiki'];
                                $realisasi_item['level'] = 2;
                                $realisasi[] = $realisasi_item;

                                if($ratarata['jml_persentase_iki']) $jml_persentase_1++;


                                $total_persentase_1 += $ratarata['rataiki'];


                            } else {

                                $IndikatorKinerja = IndikatorKinerja::where('parent_id', $value2->id)->get();


                                $total_persentase_2 = 0;
                                $jml_persentase_2 = 0;
                                $rata2 = 0;


                                foreach ($IndikatorKinerja as $key3 => $value3) {
                                  if ($value3->tipe_indikator == 'kegiatan') {

                                      // $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('indikator_kinerja_id', $value3->id)->with('penilaian_prestasi_kerja')
                                      //     ->where(function ($query) use($request,$bulan,$tahun) {
                                      //         $query->whereHas("penilaian_prestasi_kerja", function ($query) use($request,$bulan,$tahun) {
                                      //             $query->where('bulan',$bulan);
                                      //             $query->where('tahun',$tahun);
                                      //         });
                                      //     })->get();
                                      // $total_persentase_iki = 0;
                                      // $jml_persentase_iki = 0;
                                      // $rataiki = 0;
                                      // foreach ($PenilaianPrestasiKerjaItem as $keyitem => $item) {
                                      //     // hitung total realisasi dalam persen
                                      //     $jml_persentase_iki++;
                                      //     $persentase = ($item->realisasi_approved / $item->target) * 100;
                                      //     $total_persentase_iki += $persentase;
                                      // }
                                      //
                                      // if($jml_persentase_iki && $total_persentase_iki) $rataiki = $total_persentase_iki / $jml_persentase_iki;
                                      $ratarata = $this->getIkiBerdasarIkiBulanTahun($request, $value3->id, $bulan, $tahun);
                                      // cetak('level-3-keg' . ' - ' .  $value3->id. ' - ' .$rataiki);
                                      $realisasi_item['indikator_kinerja'] = $value3;
                                      $realisasi_item['value'] = $ratarata['rataiki'];
                                      $realisasi_item['level'] = 3;
                                      $realisasi[] = $realisasi_item;

                                      if($ratarata['jml_persentase_iki']) $jml_persentase_2++;

                                      $total_persentase_2 += $ratarata['rataiki'];

                                  } else {



                                  }
                                }


                                if($jml_persentase_2 && $total_persentase_2) $rata2 = $total_persentase_2 / $jml_persentase_2;
                                // cetak('level-2 - ' .  $value2->id. ' - ' .$rata2);
                                $realisasi_item['indikator_kinerja'] = $value2;
                                $realisasi_item['value'] = $rata2;
                                $realisasi_item['level'] = 2;
                                $realisasi[] = $realisasi_item;

                                $total_persentase_1 += $rata2;
                                if($jml_persentase_2) $jml_persentase_1++;


                            }
                        }
                        if($jml_persentase_1 && $total_persentase_1) $rata1 = $total_persentase_1 / $jml_persentase_1;
                        // cetak('level-1 - '.  $value1->id. ' - ' .$rata1);

                        $realisasi_item['indikator_kinerja'] = $value1;
                        $realisasi_item['value'] = $rata1;
                        $realisasi_item['level'] = 1;
                        $realisasi[] = $realisasi_item;

                        $total_persentase_0 += $rata1;
                        if($jml_persentase_1) $jml_persentase_0++;

                    }
                }

                if($jml_persentase_0 && $total_persentase_0) $rata0 = $total_persentase_0 / $jml_persentase_0;
                // cetak('level-0 - ' .  $value->indikator_kinerja_id. ' - ' .$rata0);
                $realisasi_item['indikator_kinerja'] = $IndikatorKinerjaSingle;
                $realisasi_item['value'] = $rata0;
                $realisasi_item['level'] = 0;
                $realisasi[] = $realisasi_item;



                $PenilaianPrestasiKerjaItemUpdate = PenilaianPrestasiKerjaItem::where('id', $value->id)->first();

                $PenilaianPrestasiKerjaItemUpdate->target = '100';
                $PenilaianPrestasiKerjaItemUpdate->realisasi = $rata0;
                $PenilaianPrestasiKerjaItemUpdate->capaian = $rata0/100;
                $PenilaianPrestasiKerjaItemUpdate->nilai_kinerja = ($PenilaianPrestasiKerjaItemUpdate->capaian) * $PenilaianPrestasiKerjaItemUpdate->bobot;


                $PenilaianPrestasiKerjaItemUpdate->save();
            }
        }
        // die();


        // pengecekan indikator perilaku & kualitas
        // get indikator tetap
        $IndikatorTetap = IndikatorTetap::all();
        foreach ($IndikatorTetap as $key => $value) {
            $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('penilaian_prestasi_kerja_id', $id)->where('indikator_tetap_id', $value->id)->first();

            if (empty($PenilaianPrestasiKerjaItem)) {
              $PenilaianPrestasiKerjaItem = new PenilaianPrestasiKerjaItem();
              $PenilaianPrestasiKerjaItem->penilaian_prestasi_kerja_id = $id;
              $PenilaianPrestasiKerjaItem->user_id = Auth::user()->id;
              $PenilaianPrestasiKerjaItem->indikator_tetap_id = $value->id;
              $PenilaianPrestasiKerjaItem->type = $value->type;
            }

            if ($PenilaianPrestasiKerja->user->jabatan->is_staff) {
                $PenilaianPrestasiKerjaItem->bobot = $value->bobot_staff;
            } else {
                $PenilaianPrestasiKerjaItem->bobot = $value->bobot_pimpinan;
            }


            $PenilaianPrestasiKerjaItem->target = $value->target;

            if (empty($PenilaianPrestasiKerjaItem->realisasi)) {
              $PenilaianPrestasiKerjaItem->realisasi = 0;
              $PenilaianPrestasiKerjaItem->realisasi_approved = 0;
            } else {
                if (!empty($PenilaianPrestasiKerjaItem->realisasi) && $PenilaianPrestasiKerjaItem->realisasi > $value->target) {
                  $PenilaianPrestasiKerjaItem->realisasi = $value->target;
                  $PenilaianPrestasiKerjaItem->realisasi_approved = $value->target;
                }
            }

            $PenilaianPrestasiKerjaItem->capaian = $PenilaianPrestasiKerjaItem->realisasi/$PenilaianPrestasiKerjaItem->target;
            $PenilaianPrestasiKerjaItem->nilai_kinerja = $PenilaianPrestasiKerjaItem->capaian * $PenilaianPrestasiKerjaItem->bobot;


            $PenilaianPrestasiKerjaItem->save();

        }


        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)
            ->get('first');

        if (empty($PenilaianPrestasiKerja['records']->penilaian_iku)) {
            $PenilaianIku = new PenilaianIku();
            $PenilaianIku->penilaian_prestasi_kerja_id = $id;
            $PenilaianIku->save();

        }


        $UploadAbsensi = UploadAbsensi::where('month', $PenilaianPrestasiKerja['records']->bulan)->where('year', $PenilaianPrestasiKerja['records']->tahun)->first();

        $nilai_absensi = 0;
        if (!empty($UploadAbsensi)) {
            $UploadAbsensiDetail = UploadAbsensiDetail::where('nip', $PenilaianPrestasiKerja['records']->user->nip)
              ->where('upload_absensi_id', $UploadAbsensi->id)
              ->first();

            if (!empty($UploadAbsensiDetail)) {
                $nilai_absensi = $UploadAbsensiDetail->nilai;
            }
        }

        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('penilaian_prestasi_kerja_id', $id)
            ->where('indikator_tetap_id', '3')
            ->first();
        $PenilaianPrestasiKerjaItem->realisasi = $nilai_absensi;
        $PenilaianPrestasiKerjaItem->realisasi_approved = $nilai_absensi;
        $PenilaianPrestasiKerjaItem->capaian = $nilai_absensi / $PenilaianPrestasiKerjaItem->target;
        $PenilaianPrestasiKerjaItem->nilai_kinerja = $PenilaianPrestasiKerjaItem->capaian * $PenilaianPrestasiKerjaItem->bobot;
        $PenilaianPrestasiKerjaItem->save();

        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)
            ->get('first');

        if (!isset($PenilaianPrestasiKerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }

        // Get detail jabatan apakah dia staff atau bukan
        $Jabatan = JabatanBrowseController::FetchBrowse($request)
                    ->equal('id', $PenilaianPrestasiKerja['records']->jabatan_id)->get('first');

        $IndikatorKinerjaTree = IndikatorKinerja::tree();

        if (!empty($Jabatan['records']->group_jabatan) && $Jabatan['records']->group_jabatan == 4) {

          $UnitKerjaParent = UnitKerja::where('id', MyAccount()->unit_kerja_id)->first();

          $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                            //   ->where('unit_kerja_id', $UnitKerjaParent->parent_id)
                              ->where('take', 100000)
                            //   ->whereIn('tipe_indikator', 'program')
                              ->get();

          $indikator_kerja_ids = [];

          foreach ($IndikatorKerja['records'] as $key2 => $value2) {
              if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
              $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
          }

          $tipe_indikator_ditampilkan = ['program'];

        } else if (!empty($Jabatan['records']->is_staff) && $Jabatan['records']->is_staff) {

            $indikator_kerja_ids = [];

            // list semua indikator kerja dari kegiatan yang ada di dalam 1 unit kerja
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                ->where('take', 100000)
                                ->where('tipe_indikator', 'kegiatan')
                                ->get();
            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }


            // unit_kerja_atasan
            $UnitKerjaParent = UnitKerja::where('id', MyAccount()->unit_kerja_id)->first();

            // list semua indikator kerja dari kegiatan yang ada di dalam 1 unit kerja
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                ->where('unit_kerja_id', $UnitKerjaParent->parent_id)
                                ->where('take', 100000)
                                ->where('tipe_indikator', 'kegiatan')
                                ->get();
            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }


            $tipe_indikator_ditampilkan = ['kegiatan'];

        } else {

            // list semua indikator kerja buat kepala bagian, kepala sub bagian, kepala instalasi
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                // ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                // ->where('tipe_indikator', 'iku')
                                ->where('take', 100000)
                                ->get();

            $indikator_kerja_ids = [];

            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }

            $tipe_indikator_ditampilkan = ['iku','program', 'kegiatan'];
        }

        // cetak($PenilaianPrestasiKerja['records']->toArray());
        // die();








        $jabatan_id = $PenilaianPrestasiKerja['records']->jabatan->id;
        $is_staff = $PenilaianPrestasiKerja['records']->jabatan->is_staff;
        $unit_kerja_id = $PenilaianPrestasiKerja['records']->unit_kerja_id;


        if ($is_staff) {
          // ATASAN STAFF
          $user_penilai = User::where(function ($query) use($request) {
              $query->whereHas("jabatan", function ($query) use($request) {
                  $query->whereNull('is_staff');
              });
          })->where('unit_kerja_id', $unit_kerja_id)->with('jabatan')->first();
        } else {
            // ATASAN KEPALA
            // echo
            $jabatan_parent_id = $PenilaianPrestasiKerja['records']->user->jabatan->parent_id;
            // cetak($PenilaianPrestasiKerja['records']->user->jabatan->toArray());
            // die();
            $user_penilai = User::where('jabatan_id', $jabatan_parent_id)->first();

            // cetak($user_penilai);
            // die();
        }

        $user_atasan_penilai = null;
        if (!empty($user_penilai->jabatan->parent_id)) {
            $user_atasan_penilai = User::where('jabatan_id', $user_penilai->jabatan->parent_id)->first();
        }

        $UnitKerjaTree = UnitKerja::tree();

        return view('app.penilaian_prestasi_kerja.edit.index', [
            'selected' => [],
            'data' => $PenilaianPrestasiKerja['records'],
            'indikator_kerja_ids' => $indikator_kerja_ids,
            'jabatan' => $Jabatan['records'],
            'indikator_kinerja' => $IndikatorKinerjaTree,
            'tipe_indikator_ditampilkan' => $tipe_indikator_ditampilkan,
            'user_atasan_penilai' => $user_atasan_penilai,
            'unit_kerja' => $UnitKerjaTree,
            'realisasi' => $realisasi
        ]);
    }

    public function getIkiBerdasarIkiBulanTahun(Request $request, $indikator_kinerja_id, $bulan,$tahun) {
        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('indikator_kinerja_id', $indikator_kinerja_id)->with('penilaian_prestasi_kerja')
            ->where(function ($query) use($request,$bulan,$tahun) {
                $query->whereHas("penilaian_prestasi_kerja", function ($query) use($request,$bulan,$tahun) {
                    $query->where('bulan',$bulan);
                    $query->where('tahun',$tahun);
                });
            })->get();
        $total_persentase_iki = 0;
        $jml_persentase_iki = 0;
        $rataiki = 0;
        foreach ($PenilaianPrestasiKerjaItem as $keyitem => $item) {
            // hitung total realisasi dalam persen
            $jml_persentase_iki++;
            $persentase = 0;
            if($item->realisasi_approved && $item->target)$persentase = ($item->realisasi_approved / $item->target) * 100;
            $total_persentase_iki += $persentase;
        }

        if($jml_persentase_iki && $total_persentase_iki) $rataiki = $total_persentase_iki / $jml_persentase_iki;

        return [
          'rataiki' => $rataiki,
          'jml_persentase_iki' => $jml_persentase_iki

        ];
    }


    public function Pdf(Request $request, $id)
    {


        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)
            ->get('first');

        $PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApprovalBrowseController::FetchBrowse($request)
            ->equal('penilaian_prestasi_kerja_id', $id)
            ->get()
            ;


        if (!isset($PenilaianPrestasiKerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }

        // Get detail jabatan apakah dia staff atau bukan
        $Jabatan = JabatanBrowseController::FetchBrowse($request)
                    ->equal('id', $PenilaianPrestasiKerja['records']->jabatan_id)->get('first');

        $IndikatorKinerjaTree = IndikatorKinerja::tree();

        if ($Jabatan['records']->group_jabatan == 4) {

          $UnitKerjaParent = UnitKerja::where('id', MyAccount()->unit_kerja_id)->first();

          $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                              ->where('unit_kerja_id', $UnitKerjaParent->parent_id)
                              ->where('take', 100000)
                              ->where('tipe_indikator', 'program')
                              ->get();

          $indikator_kerja_ids = [];

          foreach ($IndikatorKerja['records'] as $key2 => $value2) {
              if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
              $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
          }

          $tipe_indikator_ditampilkan = ['program'];

        } else if ($Jabatan['records']->is_staff) {

            // list semua indikator kerja dari kegiatan yang ada di dalam 1 unit kerja
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                ->where('take', 100000)
                                ->where('tipe_indikator', 'kegiatan')
                                ->get();
            // cetak($IndikatorKerja['records']->toArray());
            // die();
            $indikator_kerja_ids = [];

            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }


            $tipe_indikator_ditampilkan = ['kegiatan'];

        } else {

            // list semua indikator kerja buat kepala bagian, kepala sub bagian, kepala instalasi
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                // ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                // ->where('tipe_indikator', 'iku')
                                ->where('take', 100000)
                                ->get();

            $indikator_kerja_ids = [];

            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }

            $tipe_indikator_ditampilkan = ['iku','program'];
        }

        $jabatan_id = $PenilaianPrestasiKerja['records']->jabatan->id;
        $is_staff = $PenilaianPrestasiKerja['records']->jabatan->is_staff;
        $unit_kerja_id = $PenilaianPrestasiKerja['records']->unit_kerja_id;


        if ($is_staff) {
          // ATASAN STAFF
          $user_penilai = User::where(function ($query) use($request) {
              $query->whereHas("jabatan", function ($query) use($request) {
                  $query->whereNull('is_staff');
              });
          })->where('unit_kerja_id', $unit_kerja_id)->with('jabatan')->first();
        } else {
            // ATASAN KEPALA
            // echo
            $jabatan_parent_id = $PenilaianPrestasiKerja['records']->user->jabatan->parent_id;
            // cetak($PenilaianPrestasiKerja['records']->user->jabatan->toArray());
            // die();
            $user_penilai = User::where('jabatan_id', $jabatan_parent_id)->first();

            // cetak($user_penilai);
            // die();
        }

        $user_atasan_penilai = null;
        if (!empty($user_penilai->jabatan->parent_id)) {
            $user_atasan_penilai = User::where('jabatan_id', $user_penilai->jabatan->parent_id)->first();
        }


        // get document group_jabatan
        // $show_iku = false;
        // if ($is_staff || in_array($Jabatan['records']->group_jabatan, [3,4])) {
            $show_iku = true;
            // hide dulu aja
        // }

        $pdf = PDF::loadView('app.penilaian_prestasi_kerja.pdf.index', [
            'select' => [],
            'data' => $PenilaianPrestasiKerja['records'],
            'indikator_kerja_ids' => $indikator_kerja_ids,
            'jabatan' => $Jabatan['records'],
            'indikator_kinerja' => $IndikatorKinerjaTree,
            'tipe_indikator_ditampilkan' => $tipe_indikator_ditampilkan,
            'user_penilai' => $user_penilai,
            'user_atasan_penilai' => $user_atasan_penilai,
            'show_iku' => $show_iku,
            'penilaian_approval' => $PenilaianPrestasiKerjaApproval['records']
        ]);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream();


    }


    public function PdfIku(Request $request, $id)
    {


        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)
            ->get('first');



        if (!isset($PenilaianPrestasiKerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }

        // Get detail jabatan apakah dia staff atau bukan
        $Jabatan = JabatanBrowseController::FetchBrowse($request)
                    ->equal('id', $PenilaianPrestasiKerja['records']->jabatan_id)->get('first');

        $IndikatorKinerjaTree = IndikatorKinerja::tree();

        if ($Jabatan['records']->group_jabatan == 4) {

          $UnitKerjaParent = UnitKerja::where('id', MyAccount()->unit_kerja_id)->first();

          $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                              ->where('unit_kerja_id', $UnitKerjaParent->parent_id)
                              ->where('take', 100000)
                              ->where('tipe_indikator', 'program')
                              ->get();

          $indikator_kerja_ids = [];

          foreach ($IndikatorKerja['records'] as $key2 => $value2) {
              if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
              $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
          }

          $tipe_indikator_ditampilkan = ['program'];

        } else if ($Jabatan['records']->is_staff) {

            // list semua indikator kerja dari kegiatan yang ada di dalam 1 unit kerja
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                ->where('take', 100000)
                                ->where('tipe_indikator', 'kegiatan')
                                ->get();
            // cetak($IndikatorKerja['records']->toArray());
            // die();
            $indikator_kerja_ids = [];

            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }


            $tipe_indikator_ditampilkan = ['kegiatan'];

        } else {

            // list semua indikator kerja buat kepala bagian, kepala sub bagian, kepala instalasi
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                // ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                // ->where('tipe_indikator', 'iku')
                                ->where('take', 100000)
                                ->get();

            $indikator_kerja_ids = [];

            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }

            $tipe_indikator_ditampilkan = ['iku','program'];
        }

        $jabatan_id = $PenilaianPrestasiKerja['records']->jabatan->id;
        $is_staff = $PenilaianPrestasiKerja['records']->jabatan->is_staff;
        $unit_kerja_id = $PenilaianPrestasiKerja['records']->unit_kerja_id;


        if ($is_staff) {
          // ATASAN STAFF
          $user_penilai = User::where(function ($query) use($request) {
              $query->whereHas("jabatan", function ($query) use($request) {
                  $query->whereNull('is_staff');
              });
          })->where('unit_kerja_id', $unit_kerja_id)->with('jabatan')->first();
        } else {
            // ATASAN KEPALA
            // echo
            $jabatan_parent_id = $PenilaianPrestasiKerja['records']->user->jabatan->parent_id;
            // cetak($PenilaianPrestasiKerja['records']->user->jabatan->toArray());
            // die();
            $user_penilai = User::where('jabatan_id', $jabatan_parent_id)->first();

            // cetak($user_penilai);
            // die();
        }

        $user_atasan_penilai = null;
        if (!empty($user_penilai->jabatan->parent_id)) {
            $user_atasan_penilai = User::where('jabatan_id', $user_penilai->jabatan->parent_id)->first();
        }


        // get document group_jabatan
        $show_iku = false;
        if ($is_staff || in_array($Jabatan['records']->group_jabatan, [3,4])) {
            // $show_iku = true;
            // hide dulu aja
        }
        die();
        $pdf = PDF::loadView('app.penilaian_prestasi_kerja.pdf_iku.index', [
            'select' => [],
            'data' => $PenilaianPrestasiKerja['records'],
            'indikator_kerja_ids' => $indikator_kerja_ids,
            'jabatan' => $Jabatan['records'],
            'indikator_kinerja' => $IndikatorKinerjaTree,
            'tipe_indikator_ditampilkan' => $tipe_indikator_ditampilkan,
            'user_penilai' => $user_penilai,
            'user_atasan_penilai' => $user_atasan_penilai,
            'show_iku' => $show_iku
        ]);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream();


    }


    public function tree($data, $last_array) {
          if (empty( $data->id)) {
              return $last_array;
          } else {
              $last_array[] = $data->id;
              return $this->tree($data->parents, $last_array);
          }
    }
}
