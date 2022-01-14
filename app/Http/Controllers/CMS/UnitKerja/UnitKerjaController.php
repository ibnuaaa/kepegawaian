<?php

namespace App\Http\Controllers\CMS\UnitKerja;

use App\Http\Controllers\UnitKerja\UnitKerjaBrowseController;

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

class UnitKerjaController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'unit_kerja-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['unit_kerja-table-show'])) {
            $selected = $request['unit_kerja-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $UnitKerja = UnitKerjaBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $UnitKerja = $UnitKerja->where('search', $filter_search);
        }

        $UnitKerja = $UnitKerja->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$UnitKerja['total'], (int)$UnitKerja['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Unit Kerja'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($UnitKerja['records']) {
            $DataTable['records'] = $UnitKerja['records'];
            $DataTable['total'] = $UnitKerja['total'];
            $DataTable['show'] = $UnitKerja['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.unit_kerja.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.unit_kerja.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $UnitKerjaBrowseController = new UnitKerjaBrowseController($QueryRoute);
        $data = $UnitKerjaBrowseController->get($QueryRoute);

        return view('app.unit_kerja.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $UnitKerja = UnitKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($UnitKerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.unit_kerja.edit.index', [
            'select' => [],
            'data' => $UnitKerja['records']
        ]);
    }

}
