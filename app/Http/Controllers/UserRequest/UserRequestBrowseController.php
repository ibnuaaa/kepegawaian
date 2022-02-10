<?php

namespace App\Http\Controllers\UserRequest;

use App\Models\UserRequest;

use App\Traits\Browse;
use App\Traits\UserRequest\UserRequestCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class UserRequestBrowseController extends Controller
{
    use Browse, UserRequestCollection {
        UserRequestCollection::__construct as private __UserRequestCollectionConstruct;
    }

    protected $search = [
        'username',
        'email'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserRequestCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $UserRequest = UserRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where("$this->UserRequestTable.id", $request->user()->id);
                } else {
                    $query->where("$this->UserRequestTable.id", $request->ArrQuery->id);
                }
            }

            if (isset($request->ArrQuery->position_id)) {
                $query->where("$this->UserRequestTable.position_id", $request->ArrQuery->position_id);
            }

            if (isset($request->ArrQuery->user_id)) {
                $query->where("$this->UserRequestTable.user_id", $request->ArrQuery->user_id);
            }


            if (isset($request->ArrQuery->status_in)) {
                $query->whereIn("$this->UserRequestTable.status", $request->ArrQuery->status_in);
            }

            if (isset($request->ArrQuery->user_ids)) {
                $query->whereIn("$this->UserRequestTable.id", $request->ArrQuery->user_ids);
            }


            if (isset($request->ArrQuery->position_ids)) {
                $query->whereIn("$this->UserRequestTable.position_id", $request->ArrQuery->position_ids);
            }

            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                    foreach ($this->search as $key => $value) {
                        if($value == 'name') $query->orWhere($this->UserRequestTable.".".$value, 'like', $search);
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
            // UserRequest
            "$this->UserRequestTable.id as user.id",
            "$this->UserRequestTable.username as user.username",
            "$this->UserRequestTable.user_id as user.user_id",
            "$this->UserRequestTable.nip as user.nip",

            "$this->UserRequestTable.no_ktp as user.no_ktp",
            "$this->UserRequestTable.tanggal_lahir as user.tanggal_lahir",
            "$this->UserRequestTable.tempat_lahir as user.tempat_lahir",
            "$this->UserRequestTable.alamat as user.alamat",
            "$this->UserRequestTable.kode_pos as user.kode_pos",
            "$this->UserRequestTable.telepon as user.telepon",
            "$this->UserRequestTable.hp as user.hp",
            "$this->UserRequestTable.npwp as user.npwp",
            "$this->UserRequestTable.no_rekening as user.no_rekening",
            "$this->UserRequestTable.golongan_darah as user.golongan_darah",
            "$this->UserRequestTable.status_perkawinan_id as user.status_perkawinan_id",

            "$this->UserRequestTable.golongan_id as user.golongan_id",
            "$this->UserRequestTable.unit_kerja_id as user.unit_kerja_id",
            "$this->UserRequestTable.pendidikan_id as user.pendidikan_id",
            "$this->UserRequestTable.pendidikan_detail as user.pendidikan_detail",

            "$this->UserRequestTable.jabatan_id as user.jabatan_id",
            "$this->UserRequestTable.jabatan_fungsional_id as user.jabatan_fungsional_id",
            "$this->UserRequestTable.updated_at as user.updated_at",
            "$this->UserRequestTable.created_at as user.created_at",
            "$this->UserRequestTable.deleted_at as user.deleted_at",
            "$this->UserRequestTable.status as user.status",

            "$this->UserRequestTable.deleted_at as user.deleted_at"
       )
       ->with('jabatan_fungsional')
       ->with('golongan')
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
       ->with('user')
       ;


        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
                if ($request->get('sort') == 'id') $UserRequest->orderBy("$this->UserRequestTable.id", $request->get('sort_type'));
                else if ($request->get('sort') == 'name') $UserRequest->orderBy("$this->UserRequestTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'nip') $UserRequest->orderBy("$this->UserRequestTable.username", $request->get('sort_type'));
                else if($request->get('sort') == 'jabatan') $UserRequest->orderBy("$this->PositionTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'terbuat_pada') $UserRequest->orderBy("$this->UserRequestTable.created_at", $request->get('sort_type'));
            }
        } else {
            $UserRequest->orderBy("$this->UserRequestTable.created_at", 'desc');
        }

        // echo $UserRequest->toSql();
        // die();

       $Browse = $this->Browse($request, $UserRequest, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($UserRequest) {
                   return [ 'value' => $UserRequest->id, 'label' => $UserRequest->name ];
               });
           } else {
               $data = $this->GetUserRequestDetails($data);
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
