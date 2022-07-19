<?php

namespace App\Http\Controllers\User;

use App\Models\UserComplete;

use App\Traits\Browse;
use App\Traits\UserComplete\UserCompleteCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class UserCompleteBrowseController extends Controller
{
    use Browse, UserCompleteCollection {
        UserCompleteCollection::__construct as private __UserCompleteCollectionConstruct;
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
        $this->__UserCompleteCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $User = UserComplete::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where("$this->UserCompleteTable.id", $request->user()->id);
                } else {
                    $query->where("$this->UserCompleteTable.id", $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->username)) {
                if ($request->ArrQuery->username === 'my') {
                    $query->where("$this->UserCompleteTable.username", $request->user()->username);
                } else {
                    $query->where("$this->UserCompleteTable.username", $request->ArrQuery->username);
                }
            }

            if (isset($request->ArrQuery->position_id)) {
                $query->where("$this->UserCompleteTable.position_id", $request->ArrQuery->position_id);
            }

            if (MyAccount()->id == 1338) {
              $query->whereNotIn("$this->UserCompleteTable.id", [1341,1338,1345,1,1342]);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->Where("$this->UserCompleteTable.id", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserCompleteTable.name", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserCompleteTable.nip", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserCompleteTable.email", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserCompleteTable.username", 'like', '%'.$request->get('q').'%')
                    ;
                });
            }
            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserCompleteTable.status", $request->ArrQuery->status);
            }

            if (isset($request->ArrQuery->user_ids)) {
                $query->whereIn("$this->UserCompleteTable.id", $request->ArrQuery->user_ids);
            }

            //mail_destination
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'send_mail')) {
                $query->whereNotIn("$this->UserCompleteTable.id", [Auth::user()->id]);
            }

            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserCompleteTable.status", $request->ArrQuery->status);
            }

            if (isset($request->ArrQuery->position_ids)) {
                $query->whereIn("$this->UserCompleteTable.position_id", $request->ArrQuery->position_ids);
            }

            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                    foreach ($this->search as $key => $value) {
                        if($value == 'name') $query->orWhere($this->UserCompleteTable.".".$value, 'like', $search);
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
            "$this->UserCompleteTable.id as user.id",
            "$this->UserCompleteTable.name as user.name",
            "$this->UserCompleteTable.username as user.username",
            "$this->UserCompleteTable.nip as user.nip",
            "$this->UserCompleteTable.is_change_password as user.is_change_password",

            "$this->UserCompleteTable.no_ktp as user.no_ktp",
            "$this->UserCompleteTable.tanggal_lahir as user.tanggal_lahir",
            "$this->UserCompleteTable.tempat_lahir as user.tempat_lahir",
            "$this->UserCompleteTable.alamat as user.alamat",
            "$this->UserCompleteTable.kode_pos as user.kode_pos",
            "$this->UserCompleteTable.alamat_domisili as user.alamat_domisili",
            "$this->UserCompleteTable.kode_pos_domisili as user.kode_pos_domisili",
            "$this->UserCompleteTable.telepon as user.telepon",
            "$this->UserCompleteTable.hp as user.hp",
            "$this->UserCompleteTable.npwp as user.npwp",
            "$this->UserCompleteTable.no_rekening as user.no_rekening",
            "$this->UserCompleteTable.golongan_darah as user.golongan_darah",
            "$this->UserCompleteTable.status_perkawinan_id as user.status_perkawinan_id",

            "$this->UserCompleteTable.golongan_id as golongan_id",
            "$this->UserCompleteTable.unit_kerja_id as user.unit_kerja_id",
            "$this->UserCompleteTable.status_pegawai_id as status_pegawai_id",
            "$this->UserCompleteTable.pendidikan_id as user.pendidikan_id",
            "$this->UserCompleteTable.pendidikan_detail as user.pendidikan_detail",
            "$this->UserCompleteTable.no_str as user.no_str",
            "$this->UserCompleteTable.masa_berlaku_str as user.masa_berlaku_str",
            "$this->UserCompleteTable.no_sip as user.no_sip",

            "$this->UserCompleteTable.email as user.email",
            "$this->UserCompleteTable.gender as user.gender",
            "$this->UserCompleteTable.position_id as user.position_id",
            "$this->UserCompleteTable.jabatan_id as user.jabatan_id",
            "$this->UserCompleteTable.jabatan_fungsional_id as jabatan_fungsional_id",
            "$this->UserCompleteTable.address as user.address",
            "$this->UserCompleteTable.remember_token as user.remember_token",
            "$this->UserCompleteTable.updated_at as user.updated_at",
            "$this->UserCompleteTable.created_at as user.created_at",
            "$this->UserCompleteTable.deleted_at as user.deleted_at",

            "$this->UserCompleteTable.deleted_at as user.deleted_at"
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
       ->with('foto_akta_nikah')
       ->with('foto_bpjs')
       ->with('foto_profile')
       ->with('foto_sip')
       ->with('status_pegawai')
       ->with('plt')
       ;


        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
                if ($request->get('sort') == 'id') $User->orderBy("$this->UserCompleteTable.id", $request->get('sort_type'));
                else if ($request->get('sort') == 'name') $User->orderBy("$this->UserCompleteTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'nip') $User->orderBy("$this->UserCompleteTable.username", $request->get('sort_type'));
                else if($request->get('sort') == 'jabatan') $User->orderBy("$this->PositionTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'terbuat_pada') $User->orderBy("$this->UserCompleteTable.created_at", $request->get('sort_type'));
            }
        } else {
            $User->orderBy("$this->UserCompleteTable.created_at", 'desc');
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
               $data = $this->GetUserCompleteDetails($data);
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
