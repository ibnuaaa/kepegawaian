<?php

namespace App\Http\Controllers\CMS\IndikatorSkp;

use App\Http\Controllers\IndikatorSkp\IndikatorSkpBrowseController;

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
    public function Home(Request $request)
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
        $IndikatorSkp = IndikatorSkpBrowseController::FetchBrowse($request)
            ->where('tipe_indikator',  'iku')
            ->where('unit_kerja_id',  MyAccount()->unit_kerja_id)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $IndikatorSkp = $IndikatorSkp->where('search', $filter_search);
        }

        $IndikatorSkp = $IndikatorSkp->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$IndikatorSkp['total'], (int)$IndikatorSkp['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Indikator Kinerja'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($IndikatorSkp['records']) {
            $DataTable['records'] = $IndikatorSkp['records'];
            $DataTable['total'] = $IndikatorSkp['total'];
            $DataTable['show'] = $IndikatorSkp['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.indikator_skp.home.index', $ParseData);
    }

    public function New(Request $request, $tipe_indikator, $indikator_kinerja_id)
    {
        $IndikatorSkp = IndikatorSkpBrowseController::FetchBrowse($request)
            ->equal('id', $indikator_kinerja_id)->get('first');

        return view('app.indikator_skp.new.index', [
            'tipe_indikator' => $tipe_indikator,
            'indikator_kinerja_id' => $indikator_kinerja_id,
            'indikator_kinerja' => $IndikatorSkp['records']
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
