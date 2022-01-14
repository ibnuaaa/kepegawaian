<?php

namespace App\Http\Controllers\CMS\Golongan;

use App\Http\Controllers\Golongan\GolonganBrowseController;

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

class GolonganController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'golongan-table';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['golongan-table-show'])) {
            $selected = $request['golongan-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Golongan = GolonganBrowseController::FetchBrowse($request)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Golongan = $Golongan->where('search', $filter_search);
        }

        $Golongan = $Golongan->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$Golongan['total'], (int)$Golongan['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'id', 'label' => 'ID'],
                (object)['name' => 'name', 'label' => 'name'],
                (object)['name' => 'created_at', 'label' => 'Created At'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($Golongan['records']) {
            $DataTable['records'] = $Golongan['records'];
            $DataTable['total'] = $Golongan['total'];
            $DataTable['show'] = $Golongan['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.golongan.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.golongan.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $GolonganBrowseController = new GolonganBrowseController($QueryRoute);
        $data = $GolonganBrowseController->get($QueryRoute);

        return view('app.golongan.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $Golongan = GolonganBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($Golongan['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.golongan.edit.index', [
            'select' => [],
            'data' => $Golongan['records']
        ]);
    }

}
