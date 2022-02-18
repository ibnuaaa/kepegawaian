<?php

namespace App\Http\Controllers\CMS\User;

use App\Http\Controllers\User\UserBrowseController;
use App\Http\Controllers\UserRequest\UserRequestBrowseController;
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

class UserController extends Controller
{
    public function Home(Request $request)
    {

        $TableKey = 'user-table';

        $filter_search = $request->input('filter_search');

        if (isset($request['user-table-show'])) {
            $selected = $request['user-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $User = UserBrowseController::FetchBrowse($request)
            ->where('orderBy.blast_users.created_at', 'desc')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $User = $User->where('search', $filter_search);
        }

        $User = $User->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');



        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "Nama",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$User['total'], (int)$User['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'id', 'label' => 'ID'],
                (object)['name' => 'name', 'label' => 'Name'],
                (object)['name' => 'username', 'label' => 'username'],
                (object)['name' => 'jabatan', 'label' => 'Jabatan'],
                (object)['name' => 'terbuat_pada', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($User['records']) {
            $DataTable['records'] = $User['records'];
            $DataTable['total'] = $User['total'];
            $DataTable['show'] = $User['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];

        return view('app.user.home.index', $ParseData);
    }

    public function New(Request $request)
    {

        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

          $Positions[] = [
              'value' => '',
              'label' => '-= Pilih Hak Akses =-'
          ];

        foreach ($Position['records'] as $key => $value) {
            $Positions[] = [
                'value' => $value->id,
                'label' => $value->name
            ];
        }


        $JabatanTree = Jabatan::tree();
        $UnitKerjaTree = UnitKerja::tree();


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

        // Jabatan Fungsional
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



        return view('app.user.new.index', [
            'positions' => $Positions,
            'jabatan' => $JabatanTree,
            'jabatan_fungsional' => $JabatanFungsionalList,
            'unit_kerja' => $UnitKerjaTree,
            'golongan' => $GolonganList,

        ]);
    }


    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $UserBrowseController = new UserBrowseController($QueryRoute);
        $data = $UserBrowseController->get($QueryRoute);

        $position = Auth::user()->position_id;


        return view('app.user.detail.home.index', [
            'data' => $data->original['data']['records'],
            'id' => $id,
            'position' =>$position,
        ]);
    }


    public function Profile(Request $request)
    {
        $id = MyAccount()->id;

        $User = UserBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');

        // Position
        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $PositionList[] = [
            'value' => '',
            'label' => '-= Pilih Hak Akses =-'
        ];

        foreach ($Position['records'] as $key => $value) {
            $PositionList[] = [
                'value' => $value->id,
                'label' => $value->name
            ];
        }

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

        // Unit Kerja
        $UnitKerja = UnitKerjaBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $UnitKerjaList[] = [
            'value' => '',
            'label' => '-= Pilih Position =-'
        ];

        foreach ($UnitKerja['records'] as $key => $value) {
            $UnitKerjaList[] = [
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


        return view('app.user.profile.index', [
            'positions' => $PositionList,
            'pendidikan' => $PendidikanList,
            'unit_kerja' => $UnitKerjaList,
            'golongan' => $GolonganList,
            'tab' => 'personal',
            'data' => $User['records']
        ]);
    }

    public function ChangePassword(Request $request)
    {
        return view('app.user.change_password.index');
    }

    public function Edit(Request $request, $id)
    {




        $User = UserBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('take','all')
            ->get('fetch');

        $Positions[] = [
            'value' => '',
            'label' => '-= Pilih Position =-'
        ];

        foreach ($Position['records'] as $key => $value) {
            $Positions[] = [
                'value' => $value->id,
                'label' => $value->name
            ];
        }



        $JabatanTree = Jabatan::tree();
        $UnitKerjaTree = UnitKerja::tree();


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

        // Jabatan Fungsional
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

        return view('app.user.edit.index', [
          'positions' => $Positions,
          'jabatan' => $JabatanTree,
          'jabatan_fungsional' => $JabatanFungsionalList,
          'golongan' => $GolonganList,
          'status_pegawai' => $StatusPegawaiList,
          'unit_kerja' => $UnitKerjaTree,
          'data' => $User['records']
        ]);
    }

    public function ProfileEdit(Request $request, $tab, $id = 'me')
    {

        $page = '';
        if ($id == 'me') {
          // user mau request
          $page = 'profile';
        } else if ($id != 'me') {
          // admin
          $page = 'admin_update_profile';
        }



        // admin

        $profilePageMy = false;
        if ($id == 'me') {
            $profilePageMy = true;
            $id = MyAccount()->id;
        }

        if ($profilePageMy) {
            $User = UserRequestBrowseController::FetchBrowse($request)
                ->equal('user_id', $id)->get('first');
        } else {
            $User = UserBrowseController::FetchBrowse($request)
                ->equal('id', $id)->get('first');


        }

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

        $data = $User['records'];

        if ($page == 'admin_update_profile') {
            $data->user = $User['records'];
        }

        return view('app.user.profile_edit.index', [
            'positions' => $PositionList,
            'jabatan' => $JabatanTree,
            'pendidikan' => $PendidikanList,
            'jabatan_fungsional' => $JabatanFungsionalList,
            'unit_kerja' => $UnitKerjaTree,
            'golongan' => $GolonganList,
            'status_pegawai' => $StatusPegawaiList,
            'tab' => $tab,
            'data' => $data,
            'id' => $profilePageMy ? '' : $id,
            'page' => $page,
        ]);
    }

}
