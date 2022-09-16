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
use App\Models\UnitKerja;
use App\Models\Jabatan;
use App\Models\User;

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

        return view('app.penilaian_prestasi_kerja.edit.index', [
            'selected' => [],
            'data' => $PenilaianPrestasiKerja['records'],
            'indikator_kerja_ids' => $indikator_kerja_ids,
            'jabatan' => $Jabatan['records'],
            'indikator_kinerja' => $IndikatorKinerjaTree,
            'tipe_indikator_ditampilkan' => $tipe_indikator_ditampilkan
        ]);
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
        $show_iku = false;
        if ($is_staff || in_array($Jabatan['records']->group_jabatan, [3,4])) {
            // $show_iku = true;
            // hide dulu aja
        }

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
