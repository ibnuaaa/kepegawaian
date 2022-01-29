<?php

namespace App\Http\Controllers\CMS\IndikatorTetap;

use App\Http\Controllers\IndikatorTetap\IndikatorTetapBrowseController;

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

class IndikatorTetapController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'indikator_tetap-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['indikator_tetap-table-show'])) {
            $selected = $request['indikator_tetap-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $IndikatorTetap = IndikatorTetapBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $IndikatorTetap = $IndikatorTetap->where('search', $filter_search);
        }

        $IndikatorTetap = $IndikatorTetap->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$IndikatorTetap['total'], (int)$IndikatorTetap['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Indikator Tetap'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($IndikatorTetap['records']) {
            $DataTable['records'] = $IndikatorTetap['records'];
            $DataTable['total'] = $IndikatorTetap['total'];
            $DataTable['show'] = $IndikatorTetap['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.indikator_tetap.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.indikator_tetap.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $IndikatorTetapBrowseController = new IndikatorTetapBrowseController($QueryRoute);
        $data = $IndikatorTetapBrowseController->get($QueryRoute);

        return view('app.indikator_tetap.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $IndikatorTetap = IndikatorTetapBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($IndikatorTetap['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.indikator_tetap.edit.index', [
            'select' => [],
            'data' => $IndikatorTetap['records']
        ]);
    }

}
