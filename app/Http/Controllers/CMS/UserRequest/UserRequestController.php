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
use App\Http\Controllers\StatusPegawai\StatusPegawaiBrowseController;

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
    public function Home(Request $request, $status, $menu)
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
        $UserRequest = UserRequestBrowseController::FetchBrowse($request);

        if ($menu == 'sdm') $UserRequest = $UserRequest->where('status_sdm',  $status);
        if ($menu == 'diklat') $UserRequest = $UserRequest->where('status_diklat',  $status);

        $UserRequest = $UserRequest->where('take',  $selected)
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
            'status' => $status,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0,
            'menu' => $menu
        ];
        return view('app.user_request.home.index', $ParseData);
    }


    public function Detail(Request $request, $menu, $id)
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

        // StatusPegawai
        $StatusPegawai = StatusPegawaiBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $StatusPegawaiList[] = [
            'value' => '',
            'label' => '-= Pilih Status Pegawai =-'
        ];

        foreach ($StatusPegawai['records'] as $key => $value) {
            $StatusPegawaiList[] = [
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
            'status_pegawai' => $StatusPegawaiList,
            'page' => $menu
        ]);
    }
}
