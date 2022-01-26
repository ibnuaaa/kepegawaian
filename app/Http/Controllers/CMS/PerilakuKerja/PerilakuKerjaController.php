<?php

namespace App\Http\Controllers\CMS\PerilakuKerja;

use App\Http\Controllers\PerilakuKerja\PerilakuKerjaBrowseController;

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

class PerilakuKerjaController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'perilaku_kerja-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['perilaku_kerja-table-show'])) {
            $selected = $request['perilaku_kerja-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $PerilakuKerja = PerilakuKerjaBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $PerilakuKerja = $PerilakuKerja->where('search', $filter_search);
        }

        $PerilakuKerja = $PerilakuKerja->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$PerilakuKerja['total'], (int)$PerilakuKerja['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama PerilakuKerja'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($PerilakuKerja['records']) {
            $DataTable['records'] = $PerilakuKerja['records'];
            $DataTable['total'] = $PerilakuKerja['total'];
            $DataTable['show'] = $PerilakuKerja['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.perilaku_kerja.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.perilaku_kerja.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $PerilakuKerjaBrowseController = new PerilakuKerjaBrowseController($QueryRoute);
        $data = $PerilakuKerjaBrowseController->get($QueryRoute);

        return view('app.perilaku_kerja.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $PerilakuKerja = PerilakuKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($PerilakuKerja['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.perilaku_kerja.edit.index', [
            'select' => [],
            'data' => $PerilakuKerja['records']
        ]);
    }

}
