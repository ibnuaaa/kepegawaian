<?php

namespace App\Http\Controllers\CMS\Laporan;

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

class LaporanIkiController extends Controller
{




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
        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request);

        if(!empty($request->tahun)) $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->where('tahun', $request->tahun);
        if(!empty($request->dari_bulan)) $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->where('dari_bulan', $request->dari_bulan);
        if(!empty($request->sampai_bulan)) $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->where('sampai_bulan', $request->sampai_bulan);

        $user = null;
        $user_penilai = null;

        if(!empty($request->user_id)) {
          $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->where('user_id', $request->user_id);

          $user = User::where('id', $request->user_id)->with('jabatan')->with('golongan')->first();

        }

        // $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->where('type', 'skp');
        // $PenilaianPrestasiKerja = $PenilaianPrestasiKerja->get('fetch');



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
            'unshow_filter' => true,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'nip', 'label' => 'nip'],
                (object)['name' => 'nama', 'label' => 'nama'],
                (object)['name' => 'bulan', 'label' => 'bulan'],
                (object)['name' => 'nilai_kuantitas', 'label' => 'nilai<br>kuantitas'],
                (object)['name' => 'nilai_kualitas', 'label' => 'nilai<br>kualitas'],
                (object)['name' => 'nilai_perilaku', 'label' => 'nilai<br>perilaku'],
                (object)['name' => 'nilai_tambahan', 'label' => 'nilai<br>tambahan'],
                (object)['name' => 'total_iki', 'label' => 'total<br>iki'],
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
            'tahun' => $request->tahun,
            'dari_bulan' => $request->dari_bulan,
            'sampai_bulan' => $request->sampai_bulan,
            'user' => $user,
        ];
        return view('app.laporan.laporan_iki.index', $ParseData);
    }

}
