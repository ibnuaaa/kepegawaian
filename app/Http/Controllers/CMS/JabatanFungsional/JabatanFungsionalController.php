<?php

namespace App\Http\Controllers\CMS\JabatanFungsional;

use App\Http\Controllers\JabatanFungsional\JabatanFungsionalBrowseController;

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

class JabatanFungsionalController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'jabatan_fungsional-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['jabatan_fungsional-table-show'])) {
            $selected = $request['jabatan_fungsional-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $JabatanFungsional = JabatanFungsionalBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $JabatanFungsional = $JabatanFungsional->where('search', $filter_search);
        }

        $JabatanFungsional = $JabatanFungsional->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$JabatanFungsional['total'], (int)$JabatanFungsional['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama JabatanFungsional'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($JabatanFungsional['records']) {
            $DataTable['records'] = $JabatanFungsional['records'];
            $DataTable['total'] = $JabatanFungsional['total'];
            $DataTable['show'] = $JabatanFungsional['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.jabatan_fungsional.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.jabatan_fungsional.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $JabatanFungsionalBrowseController = new JabatanFungsionalBrowseController($QueryRoute);
        $data = $JabatanFungsionalBrowseController->get($QueryRoute);

        return view('app.jabatan_fungsional.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $JabatanFungsional = JabatanFungsionalBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($JabatanFungsional['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.jabatan_fungsional.edit.index', [
            'select' => [],
            'data' => $JabatanFungsional['records']
        ]);
    }

}
