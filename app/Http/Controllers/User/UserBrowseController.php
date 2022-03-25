<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Traits\Browse;
use App\Traits\User\UserCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class UserBrowseController extends Controller
{
    use Browse, UserCollection {
        UserCollection::__construct as private __UserCollectionConstruct;
    }

    protected $search = [
        'name',
        'username',
        'email'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $User = User::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where("$this->UserTable.id", $request->user()->id);
                } else {
                    $query->where("$this->UserTable.id", $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->username)) {
                if ($request->ArrQuery->username === 'my') {
                    $query->where("$this->UserTable.player_username", $request->user()->username);
                } else {
                    $query->where("$this->UserTable.player_username", $request->ArrQuery->username);
                }
            }

            if (isset($request->ArrQuery->position_id)) {
                $query->where("$this->UserTable.position_id", $request->ArrQuery->position_id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->Where("$this->UserTable.id", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.name", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.nip", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.email", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.username", 'like', '%'.$request->get('q').'%')
                    ;
                });
            }
            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserTable.status", $request->ArrQuery->status);
            }

            if (isset($request->ArrQuery->user_ids)) {
                $query->whereIn("$this->UserTable.id", $request->ArrQuery->user_ids);
            }

            //mail_destination
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'send_mail')) {
                $query->whereNotIn("$this->UserTable.id", [Auth::user()->id]);
            }

            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserTable.status", $request->ArrQuery->status);
            }

            if (isset($request->ArrQuery->position_ids)) {
                $query->whereIn("$this->UserTable.position_id", $request->ArrQuery->position_ids);
            }

            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                    foreach ($this->search as $key => $value) {
                        if($value == 'name') $query->orWhere($this->UserTable.".".$value, 'like', $search);
                        else $query->orWhere($value, 'like', $search);

                    }
               });
            }
       })



       // `no_ktp`
       // `tanggal_lahir`
       // `tempat_lahir`
       // `alamat`
       // `kode_pos`
       // `telepon`
       // `hp`
       // `npwp`
       // `no_rekening`
       // `golongan_darah`
       // `status_perkawinan_id`
       // `golongan_id`
       // `unit_kerja_id`
       // `pendidikan_id`
       // `pendidikan_detail`


       ->select(
            // User
            "$this->UserTable.id as user.id",
            "$this->UserTable.name as user.name",
            "$this->UserTable.username as user.username",
            "$this->UserTable.nip as user.nip",
            "$this->UserTable.is_change_password as user.is_change_password",

            "$this->UserTable.no_ktp as user.no_ktp",
            "$this->UserTable.tanggal_lahir as user.tanggal_lahir",
            "$this->UserTable.tempat_lahir as user.tempat_lahir",
            "$this->UserTable.alamat as user.alamat",
            "$this->UserTable.kode_pos as user.kode_pos",
            "$this->UserTable.alamat_domisili as user.alamat_domisili",
            "$this->UserTable.kode_pos_domisili as user.kode_pos_domisili",
            "$this->UserTable.telepon as user.telepon",
            "$this->UserTable.hp as user.hp",
            "$this->UserTable.npwp as user.npwp",
            "$this->UserTable.no_rekening as user.no_rekening",
            "$this->UserTable.golongan_darah as user.golongan_darah",
            "$this->UserTable.status_perkawinan_id as user.status_perkawinan_id",

            "$this->UserTable.golongan_id as golongan_id",
            "$this->UserTable.unit_kerja_id as user.unit_kerja_id",
            "$this->UserTable.status_pegawai_id as status_pegawai_id",
            "$this->UserTable.pendidikan_id as user.pendidikan_id",
            "$this->UserTable.pendidikan_detail as user.pendidikan_detail",
            "$this->UserTable.no_str as user.no_str",
            "$this->UserTable.masa_berlaku_str as user.masa_berlaku_str",
            "$this->UserTable.no_sip as user.no_sip",

            "$this->UserTable.email as user.email",
            "$this->UserTable.gender as user.gender",
            "$this->UserTable.position_id as user.position_id",
            "$this->UserTable.jabatan_id as user.jabatan_id",
            "$this->UserTable.jabatan_fungsional_id as jabatan_fungsional_id",
            "$this->UserTable.address as user.address",
            "$this->UserTable.remember_token as user.remember_token",
            "$this->UserTable.updated_at as user.updated_at",
            "$this->UserTable.created_at as user.created_at",
            "$this->UserTable.deleted_at as user.deleted_at",

            "$this->UserTable.deleted_at as user.deleted_at"
       )
       ->with('jabatan_fungsional')
       ->with('golongan')
       ->with('status_pegawai')
       ->with('user_pendidikan')
       ->with('user_pelatihan')
       ->with('user_keluarga')
       ->with('user_jabatan')
       ->with('user_jabatan_fungsional')
       ->with('user_golongan')
       ->with('foto_ktp')
       ->with('foto_npwp')
       ->with('foto_kk')
       ->with('foto_bpjs')
       ->with('foto_profile')
       ->with('foto_sip')
       ->with('status_pegawai')
       ;


        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
                if ($request->get('sort') == 'id') $User->orderBy("$this->UserTable.id", $request->get('sort_type'));
                else if ($request->get('sort') == 'name') $User->orderBy("$this->UserTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'nip') $User->orderBy("$this->UserTable.username", $request->get('sort_type'));
                else if($request->get('sort') == 'jabatan') $User->orderBy("$this->PositionTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'terbuat_pada') $User->orderBy("$this->UserTable.created_at", $request->get('sort_type'));
            }
        } else {
            $User->orderBy("$this->UserTable.created_at", 'desc');
        }

        // echo $User->toSql();
        // die();

       $Browse = $this->Browse($request, $User, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($User) {
                   return [ 'value' => $User->id, 'label' => $User->name ];
               });
           } else {
               $data = $this->GetUserDetails($data);
           }
           return $data;
       });
       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        $position = [];
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'user.', $item);
                $this->Group($position, $key, 'position.', $item);
            }
            $item->position = $position;
            return $item;
        });
    }
}
