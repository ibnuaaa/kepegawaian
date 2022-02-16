<?php

namespace App\Http\Controllers\CMS\Pelatihan;

use App\Http\Controllers\Pelatihan\PelatihanBrowseController;

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

class PelatihanController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'pelatihan-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['pelatihan-table-show'])) {
            $selected = $request['pelatihan-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $Pelatihan = PelatihanBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Pelatihan = $Pelatihan->where('search', $filter_search);
        }

        $Pelatihan = $Pelatihan->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$Pelatihan['total'], (int)$Pelatihan['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Pelatihan'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($Pelatihan['records']) {
            $DataTable['records'] = $Pelatihan['records'];
            $DataTable['total'] = $Pelatihan['total'];
            $DataTable['show'] = $Pelatihan['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.pelatihan.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.pelatihan.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $PelatihanBrowseController = new PelatihanBrowseController($QueryRoute);
        $data = $PelatihanBrowseController->get($QueryRoute);

        return view('app.pelatihan.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $Pelatihan = PelatihanBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($Pelatihan['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.pelatihan.edit.index', [
            'select' => [],
            'data' => $Pelatihan['records']
        ]);
    }

}
