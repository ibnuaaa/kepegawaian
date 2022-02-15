<?php

namespace App\Http\Controllers\CMS\StatusPegawai;

use App\Http\Controllers\StatusPegawai\StatusPegawaiBrowseController;

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

class StatusPegawaiController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'status_pegawai-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['status_pegawai-table-show'])) {
            $selected = $request['status_pegawai-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $StatusPegawai = StatusPegawaiBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $StatusPegawai = $StatusPegawai->where('search', $filter_search);
        }

        $StatusPegawai = $StatusPegawai->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$StatusPegawai['total'], (int)$StatusPegawai['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Status Pegawai'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($StatusPegawai['records']) {
            $DataTable['records'] = $StatusPegawai['records'];
            $DataTable['total'] = $StatusPegawai['total'];
            $DataTable['show'] = $StatusPegawai['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.status_pegawai.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.status_pegawai.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $StatusPegawaiBrowseController = new StatusPegawaiBrowseController($QueryRoute);
        $data = $StatusPegawaiBrowseController->get($QueryRoute);

        return view('app.status_pegawai.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $StatusPegawai = StatusPegawaiBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($StatusPegawai['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.status_pegawai.edit.index', [
            'select' => [],
            'data' => $StatusPegawai['records']
        ]);
    }

}
