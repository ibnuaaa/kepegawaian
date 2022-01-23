<?php

namespace App\Http\Controllers\CMS\PenilaianPrestasiKerja;

use App\Http\Controllers\PenilaianPrestasiKerja\PenilaianPrestasiKerjaBrowseController;

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

class PenilaianPrestasiKerjaController extends Controller
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
        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
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
                (object)['name' => 'name', 'label' => 'Nama PenilaianPrestasiKerja'],
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

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
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

    public function Edit(Request $request, $id)
    {
        $PenilaianPrestasiKerja = PenilaianPrestasiKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($PenilaianPrestasiKerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.penilaian_prestasi_kerja.edit.index', [
            'select' => [],
            'data' => $PenilaianPrestasiKerja['records']
        ]);
    }

}
