<?php

namespace App\Http\Controllers\CMS\EKinerjaIkt;

use App\Http\Controllers\EKinerjaIkt\EKinerjaIktBrowseController;

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

class EKinerjaIktController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'e_kinerja_ikt-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['e_kinerja_ikt-table-show'])) {
            $selected = $request['e_kinerja_ikt-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $EKinerjaIkt = EKinerjaIktBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $EKinerjaIkt = $EKinerjaIkt->where('search', $filter_search);
        }

        $EKinerjaIkt = $EKinerjaIkt->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$EKinerjaIkt['total'], (int)$EKinerjaIkt['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'month', 'label' => 'Bulan'],
                (object)['name' => 'year', 'label' => 'Tahun'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($EKinerjaIkt['records']) {
            $DataTable['records'] = $EKinerjaIkt['records'];
            $DataTable['total'] = $EKinerjaIkt['total'];
            $DataTable['show'] = $EKinerjaIkt['show'];
        }
        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.e_kinerja_ikt.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.e_kinerja_ikt.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $EKinerjaIktBrowseController = new EKinerjaIktBrowseController($QueryRoute);
        $data = $EKinerjaIktBrowseController->get($QueryRoute);

        return view('app.e_kinerja_ikt.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {


        $EKinerjaIkt = EKinerjaIktBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($EKinerjaIkt['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.e_kinerja_ikt.edit.index', [
            'select' => [],
            'data' => $EKinerjaIkt['records']
        ]);
    }

}
