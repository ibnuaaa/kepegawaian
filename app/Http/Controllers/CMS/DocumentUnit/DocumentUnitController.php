<?php

namespace App\Http\Controllers\CMS\DocumentUnit;

use App\Http\Controllers\DocumentUnit\DocumentUnitBrowseController;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\UnitKerja;

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

class DocumentUnitController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'document_unit-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['document_unit-table-show'])) {
            $selected = $request['document_unit-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $DocumentUnit = DocumentUnitBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $DocumentUnit = $DocumentUnit->where('search', $filter_search);
        }

        $DocumentUnit = $DocumentUnit->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$DocumentUnit['total'], (int)$DocumentUnit['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama Dokumen'],
                (object)['name' => 'link file', 'label' => 'link file'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($DocumentUnit['records']) {
            $DataTable['records'] = $DocumentUnit['records'];
            $DataTable['total'] = $DocumentUnit['total'];
            $DataTable['show'] = $DocumentUnit['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.document_unit.home.index', $ParseData);
    }

    public function New(Request $request)
    {

        $UnitKerjaTree = UnitKerja::tree();

        return view('app.document_unit.new.index', [
            'select' => [],
            'unit_kerja' => $UnitKerjaTree
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $DocumentUnitBrowseController = new DocumentUnitBrowseController($QueryRoute);
        $data = $DocumentUnitBrowseController->get($QueryRoute);

        return view('app.document_unit.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $DocumentUnit = DocumentUnitBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($DocumentUnit['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }

        $UnitKerjaTree = UnitKerja::tree();

        return view('app.document_unit.edit.index', [
            'select' => [],
            'data' => $DocumentUnit['records'],
            'unit_kerja' => $UnitKerjaTree
        ]);
    }

}
