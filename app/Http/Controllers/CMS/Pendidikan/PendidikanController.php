<?php

namespace App\Http\Controllers\CMS\Pendidikan;

use App\Http\Controllers\Pendidikan\PendidikanBrowseController;

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

class PendidikanController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'pendidikan-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['pendidikan-table-show'])) {
            $selected = $request['pendidikan-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $Pendidikan = PendidikanBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Pendidikan = $Pendidikan->where('search', $filter_search);
        }

        $Pendidikan = $Pendidikan->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$Pendidikan['total'], (int)$Pendidikan['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Pendidikan'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($Pendidikan['records']) {
            $DataTable['records'] = $Pendidikan['records'];
            $DataTable['total'] = $Pendidikan['total'];
            $DataTable['show'] = $Pendidikan['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.pendidikan.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.pendidikan.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $PendidikanBrowseController = new PendidikanBrowseController($QueryRoute);
        $data = $PendidikanBrowseController->get($QueryRoute);

        return view('app.pendidikan.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $Pendidikan = PendidikanBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($Pendidikan['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.pendidikan.edit.index', [
            'select' => [],
            'data' => $Pendidikan['records']
        ]);
    }

}
