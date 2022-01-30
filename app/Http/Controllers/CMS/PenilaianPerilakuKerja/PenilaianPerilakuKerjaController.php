<?php

namespace App\Http\Controllers\CMS\PenilaianPerilakuKerja;

use App\Http\Controllers\PenilaianPrestasiKerja\PenilaianPrestasiKerjaBrowseController;
use App\Http\Controllers\IndikatorKinerja\IndikatorKinerjaBrowseController;
use App\Http\Controllers\PenilaianPerilakuKerjaItem\PenilaianPerilakuKerjaItemBrowseController;


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

use Illuminate\Support\Facades\Auth;

class PenilaianPerilakuKerjaController extends Controller
{


    public function Home(Request $request)
    {
        $TableKey = 'penilaian_perilaku_kerja-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['penilaian_perilaku_kerja-table-show'])) {
            $selected = $request['penilaian_perilaku_kerja-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $PenilaianPerilakuKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->where('take', $selected)
            ->where('for', 'penilaian_perilaku')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $PenilaianPerilakuKerja = $PenilaianPerilakuKerja->where('search', $filter_search);
        }

        $PenilaianPerilakuKerja = $PenilaianPerilakuKerja->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$PenilaianPerilakuKerja['total'], (int)$PenilaianPerilakuKerja['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'bulan', 'label' => 'Bulan - Tahun'],
                (object)['name' => 'nama', 'label' => 'nama'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($PenilaianPerilakuKerja['records']) {
            $DataTable['records'] = $PenilaianPerilakuKerja['records'];
            $DataTable['total'] = $PenilaianPerilakuKerja['total'];
            $DataTable['show'] = $PenilaianPerilakuKerja['show'];
        }

        // Get detail jabatan apakah dia staff atau bukan dengan cara lihat is_staff nya
        $Jabatan = JabatanBrowseController::FetchBrowse($request)
                    ->equal('id', MyAccount()->jabatan_id)->get('first');

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0,
            'jabatan' => $Jabatan['records'],
        ];
        return view('app.penilaian_perilaku_kerja.home.index', $ParseData);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $PenilaianPrestasiKerjaBrowseController = new PenilaianPrestasiKerjaBrowseController($QueryRoute);
        $data = $PenilaianPrestasiKerjaBrowseController->get($QueryRoute);

        return view('app.penilaian_perilaku_kerja.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $PenilaianPerilakuKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)
            ->get('first');



        if (!isset($PenilaianPerilakuKerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }

        // Get detail jabatan apakah dia staff atau bukan
        $Jabatan = JabatanBrowseController::FetchBrowse($request)
                    ->equal('id', $PenilaianPerilakuKerja['records']->jabatan_id)->get('first');

        $IndikatorKinerjaTree = IndikatorKinerja::tree();

        if ($Jabatan['records']->is_staff) {

            // list semua indikator kerja dari kegiatan yang ada di dalam 1 unit kerja
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                // ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                ->where('tipe_indikator', 'kegiatan')
                                ->get('');
            // cetak($IndikatorKerja['records']->toArray());
            // die();
            $indikator_kerja_ids = [];

            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }


            $tipe_indikator_ditampilkan = 'kegiatan';

        } else {

            // list semua indikator kerja buat kepala bagian, kepala sub bagian, kepala instalasi
            $IndikatorKerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
                                // ->where('unit_kerja_id', MyAccount()->unit_kerja_id)
                                // ->where('tipe_indikator', 'iku')
                                ->where('take', 100000)
                                ->get('all');

            $indikator_kerja_ids = [];

            foreach ($IndikatorKerja['records'] as $key2 => $value2) {
                if(!empty($value2->id)) $indikator_kerja_ids[] = $value2->id;
                $indikator_kerja_ids = array_merge($indikator_kerja_ids,$this->tree($value2->parents, []));
            }

            $tipe_indikator_ditampilkan = 'iku';
        }



        return view('app.penilaian_perilaku_kerja.edit.index', [
            'select' => [],
            'data' => $PenilaianPerilakuKerja['records'],
            'indikator_kerja_ids' => $indikator_kerja_ids,
            'jabatan' => $Jabatan['records'],
            'indikator_kinerja' => $IndikatorKinerjaTree,
            'tipe_indikator_ditampilkan' => $tipe_indikator_ditampilkan
        ]);
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
