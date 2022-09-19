<?php

namespace App\Http\Controllers\CMS\UploadAbsensi;

use App\Http\Controllers\UploadAbsensi\UploadAbsensiBrowseController;

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

class UploadAbsensiController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'upload_absensi-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['upload_absensi-table-show'])) {
            $selected = $request['upload_absensi-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $UploadAbsensi = UploadAbsensiBrowseController::FetchBrowse($request)
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $UploadAbsensi = $UploadAbsensi->where('search', $filter_search);
        }

        $UploadAbsensi = $UploadAbsensi->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$UploadAbsensi['total'], (int)$UploadAbsensi['query']->take, ___TableGetCurrentPage($request, $TableKey)),
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

        if ($UploadAbsensi['records']) {
            $DataTable['records'] = $UploadAbsensi['records'];
            $DataTable['total'] = $UploadAbsensi['total'];
            $DataTable['show'] = $UploadAbsensi['show'];
        }
        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.upload_absensi.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.upload_absensi.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $UploadAbsensiBrowseController = new UploadAbsensiBrowseController($QueryRoute);
        $data = $UploadAbsensiBrowseController->get($QueryRoute);

        return view('app.upload_absensi.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {


        $UploadAbsensi = UploadAbsensiBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($UploadAbsensi['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.upload_absensi.edit.index', [
            'select' => [],
            'data' => $UploadAbsensi['records']
        ]);
    }

}
