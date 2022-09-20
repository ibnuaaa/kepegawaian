<?php

namespace App\Http\Controllers\CMS\PenilaianPrestasiKerjaApproval;

use App\Http\Controllers\PenilaianPrestasiKerjaApproval\PenilaianPrestasiKerjaApprovalBrowseController;

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

class PenilaianPrestasiKerjaApprovalController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'penilaian_prestasi_kerja_approval-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['penilaian_prestasi_kerja_approval-table-show'])) {
            $selected = $request['penilaian_prestasi_kerja_approval-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApprovalBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('for', 'approval')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $PenilaianPrestasiKerjaApproval = $PenilaianPrestasiKerjaApproval->where('search', $filter_search);
        }

        $PenilaianPrestasiKerjaApproval = $PenilaianPrestasiKerjaApproval->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$PenilaianPrestasiKerjaApproval['total'], (int)$PenilaianPrestasiKerjaApproval['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Pegawai'],
                (object)['name' => 'periode', 'label' => 'Periode'],
                (object)['name' => 'catatan', 'label' => 'Catatan'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($PenilaianPrestasiKerjaApproval['records']) {
            $DataTable['records'] = $PenilaianPrestasiKerjaApproval['records'];
            $DataTable['total'] = $PenilaianPrestasiKerjaApproval['total'];
            $DataTable['show'] = $PenilaianPrestasiKerjaApproval['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.penilaian_prestasi_kerja_approval.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.penilaian_prestasi_kerja_approval.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $PenilaianPrestasiKerjaApprovalBrowseController = new PenilaianPrestasiKerjaApprovalBrowseController($QueryRoute);
        $data = $PenilaianPrestasiKerjaApprovalBrowseController->get($QueryRoute);

        return view('app.penilaian_prestasi_kerja_approval.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApprovalBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($PenilaianPrestasiKerjaApproval['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.penilaian_prestasi_kerja_approval.edit.index', [
            'select' => [],
            'data' => $PenilaianPrestasiKerjaApproval['records']
        ]);
    }

}
