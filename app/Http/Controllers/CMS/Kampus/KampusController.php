<?php

namespace App\Http\Controllers\CMS\Kampus;

use App\Http\Controllers\Kampus\KampusBrowseController;

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

class KampusController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'kampus-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['kampus-table-show'])) {
            $selected = $request['kampus-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $Kampus = KampusBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Kampus = $Kampus->where('search', $filter_search);
        }

        $Kampus = $Kampus->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$Kampus['total'], (int)$Kampus['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Kampus'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($Kampus['records']) {
            $DataTable['records'] = $Kampus['records'];
            $DataTable['total'] = $Kampus['total'];
            $DataTable['show'] = $Kampus['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.kampus.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.kampus.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $KampusBrowseController = new KampusBrowseController($QueryRoute);
        $data = $KampusBrowseController->get($QueryRoute);

        return view('app.kampus.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $Kampus = KampusBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($Kampus['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.kampus.edit.index', [
            'select' => [],
            'data' => $Kampus['records']
        ]);
    }

}
