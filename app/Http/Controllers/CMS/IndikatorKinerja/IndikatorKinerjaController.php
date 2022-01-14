<?php

namespace App\Http\Controllers\CMS\IndikatorKinerja;

use App\Http\Controllers\IndikatorKinerja\IndikatorKinerjaBrowseController;

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

class IndikatorKinerjaController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'indikator_kinerja-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['indikator_kinerja-table-show'])) {
            $selected = $request['indikator_kinerja-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $IndikatorKinerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $IndikatorKinerja = $IndikatorKinerja->where('search', $filter_search);
        }

        $IndikatorKinerja = $IndikatorKinerja->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$IndikatorKinerja['total'], (int)$IndikatorKinerja['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Indikator Kinerja'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($IndikatorKinerja['records']) {
            $DataTable['records'] = $IndikatorKinerja['records'];
            $DataTable['total'] = $IndikatorKinerja['total'];
            $DataTable['show'] = $IndikatorKinerja['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.indikator_kinerja.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.indikator_kinerja.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $IndikatorKinerjaBrowseController = new IndikatorKinerjaBrowseController($QueryRoute);
        $data = $IndikatorKinerjaBrowseController->get($QueryRoute);

        return view('app.indikator_kinerja.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $IndikatorKinerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($IndikatorKinerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.indikator_kinerja.edit.index', [
            'select' => [],
            'data' => $IndikatorKinerja['records']
        ]);
    }

}
