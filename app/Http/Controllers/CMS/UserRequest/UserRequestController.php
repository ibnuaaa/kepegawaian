<?php

namespace App\Http\Controllers\CMS\UserRequest;

use App\Http\Controllers\UserRequest\UserRequestBrowseController;

use App\Http\Controllers\User\UserBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;
use App\Http\Controllers\Jabatan\JabatanBrowseController;

use App\Http\Controllers\Golongan\GolonganBrowseController;
use App\Http\Controllers\Pendidikan\PendidikanBrowseController;
use App\Http\Controllers\JabatanFungsional\JabatanFungsionalBrowseController;
use App\Http\Controllers\UnitKerja\UnitKerjaBrowseController;

use App\Models\Jabatan;
use App\Models\UnitKerja;


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

class UserRequestController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'user_request-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['user_request-table-show'])) {
            $selected = $request['user_request-table-show'];
        }
        else {
            $selected = 10;
        }

        $options = array(5,10,15,20);
        $UserRequest = UserRequestBrowseController::FetchBrowse($request)
            ->where('status_in',  ['request_approval','approved'])
            ->where('take',  $selected)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $UserRequest = $UserRequest->where('search', $filter_search);
        }

        $UserRequest = $UserRequest->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$UserRequest['total'], (int)$UserRequest['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'No', 'label' => 'No'],
                (object)['name' => 'name', 'label' => 'Nama UserRequest'],
                (object)['name' => 'status', 'label' => 'status'],
                (object)['name' => 'created_at', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'Aksi']
            ],
            'records' => []
        ];

        if ($UserRequest['records']) {
            $DataTable['records'] = $UserRequest['records'];
            $DataTable['total'] = $UserRequest['total'];
            $DataTable['show'] = $UserRequest['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.user_request.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.user_request.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {

        $tab = 'personal';


        $profilePageMy = false;
        if ($id == 'me') {
            $profilePageMy = true;
            $id = MyAccount()->id;
        }

        $User = UserRequestBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');

        // Position
        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $PositionList[] = [
            'value' => '',
            'label' => '-= Pilih Position =-'
        ];

        foreach ($Position['records'] as $key => $value) {
            $PositionList[] = [
                'value' => $value->id,
                'label' => $value->name
            ];
        }

        $JabatanTree = Jabatan::tree();
        $UnitKerjaTree = UnitKerja::tree();

        // Pendidikan
        $Pendidikan = PendidikanBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $PendidikanList[] = [
            'value' => '',
            'label' => '-= Pilih Pendidikan =-'
        ];

        foreach ($Pendidikan['records'] as $key => $value) {
            $PendidikanList[] = [
                'value' => $value->id,
                'label' => $value->name
            ];
        }

        // JabatanFungsional
        $JabatanFungsional = JabatanFungsionalBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $JabatanFungsionalList[] = [
            'value' => '',
            'label' => '-= Pilih Jabatan Fungsional =-'
        ];

        foreach ($JabatanFungsional['records'] as $key => $value) {
            $JabatanFungsionalList[] = [
                'value' => $value->id,
                'label' => $value->name
            ];
        }


        // Golongan
        $Golongan = GolonganBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $GolonganList[] = [
            'value' => '',
            'label' => '-= Pilih Golongan =-'
        ];

        foreach ($Golongan['records'] as $key => $value) {
            $GolonganList[] = [
                'value' => $value->id,
                'label' => $value->pangkat . '/' . $value->golongan
            ];
        }



        return view('app.user.profile_edit.index', [
            'positions' => $PositionList,
            'jabatan' => $JabatanTree,
            'pendidikan' => $PendidikanList,
            'jabatan_fungsional' => $JabatanFungsionalList,
            'unit_kerja' => $UnitKerjaTree,
            'golongan' => $GolonganList,
            'tab' => $tab,
            'data' => $User['records'],
            'id' => $profilePageMy ? '' : $id,
            'page' => 'user_request'
        ]);
    }

    public function Edit(Request $request, $id)
    {
        $UserRequest = UserRequestBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($UserRequest['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.user_request.edit.index', [
            'select' => [],
            'data' => $UserRequest['records']
        ]);
    }

}