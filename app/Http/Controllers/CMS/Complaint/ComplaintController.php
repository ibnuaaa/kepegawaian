<?php

namespace App\Http\Controllers\CMS\Complaint;

use App\Http\Controllers\Complaint\ComplaintBrowseController;

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

class ComplaintController extends Controller
{
    public function Home(Request $request, $menu = 'inbox')
    {

        $TableKey = 'complaint-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['complaint-table-show'])) {
            $selected = $request['complaint-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $Complaint = ComplaintBrowseController::FetchBrowse($request)
            ->where('for', $menu)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Complaint = $Complaint->where('search', $filter_search);
        }

        $Complaint = $Complaint->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$Complaint['total'], (int)$Complaint['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Complaint'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($Complaint['records']) {
            $DataTable['records'] = $Complaint['records'];
            $DataTable['total'] = $Complaint['total'];
            $DataTable['show'] = $Complaint['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'menu' => $menu,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.complaint.home.index', $ParseData);
    }

    public function Detail(Request $request, $menu, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $ComplaintBrowseController = new ComplaintBrowseController($QueryRoute);
        $data = $ComplaintBrowseController->get($QueryRoute);

        return view('app.complaint.detail.index', [
          'data' => $data->original['data']['records'],
          'menu' => $menu,
          'is_detail' => 'y'
        ]);
    }

    public function Edit(Request $request, $id)
    {
        $Complaint = ComplaintBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($Complaint['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.complaint.edit.index', [
            'select' => [],
            'menu' => '',
            'data' => $Complaint['records']
        ]);
    }

}
