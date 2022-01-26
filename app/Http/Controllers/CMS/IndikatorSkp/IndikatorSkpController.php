<?php

namespace App\Http\Controllers\CMS\IndikatorSkp;

use App\Http\Controllers\IndikatorSkp\IndikatorSkpBrowseController;
use App\Http\Controllers\PenilaianPrestasiKerja\PenilaianPrestasiKerjaBrowseController;
use App\Http\Controllers\PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemBrowseController;

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

use Illuminate\Support\Facades\Auth;

class IndikatorSkpController extends Controller
{


    public function New(Request $request, $tipe_indikator, $indikator_kinerja_id, $penilaian_prestasi_kerja_id)
    {
        $IndikatorSkp = IndikatorSkpBrowseController::FetchBrowse($request)
            ->equal('id', $indikator_kinerja_id)->get('first');

        return view('app.indikator_skp.new.index', [
            'tipe_indikator' => $tipe_indikator,
            'indikator_kinerja_id' => $indikator_kinerja_id,
            'indikator_kinerja' => $IndikatorSkp['records'],
            'penilaian_prestasi_kerja_id' => $penilaian_prestasi_kerja_id
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $IndikatorSkpBrowseController = new IndikatorSkpBrowseController($QueryRoute);
        $data = $IndikatorSkpBrowseController->get($QueryRoute);

        return view('app.indikator_skp.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $IndikatorSkp = IndikatorSkpBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($IndikatorSkp['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.indikator_skp.edit.index', [
            'select' => [],
            'data' => $IndikatorSkp['records']
        ]);
    }




}
