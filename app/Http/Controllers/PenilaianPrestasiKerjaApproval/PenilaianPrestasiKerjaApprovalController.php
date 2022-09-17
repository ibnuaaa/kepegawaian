<?php

namespace App\Http\Controllers\PenilaianPrestasiKerjaApproval;

use App\Models\PenilaianPrestasiKerjaApproval;
use App\Models\PenilaianPrestasiKerjaReject;
use App\Models\PenilaianPrestasiKerja;
use App\Models\User;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class PenilaianPrestasiKerjaApprovalController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'code',
        'name'
    ];
    public function get(Request $request)
    {
        $PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApproval::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->information()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                  $query->where('code', 'like', $search);
                  $query->orWhere('name', 'like', $search);
               } else {
                   $query->where(function ($query) use($search) {
                       foreach ($this->search as $key => $value) {
                           $query->orWhere($value, 'like', $search);
                       }
                   });
               }
           }
        });
        $Browse = $this->Browse($request, $PenilaianPrestasiKerjaApproval, function ($data) use($request) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Approve(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $uuid = Uuid::generate()->string;
        if (empty($Model->PenilaianPrestasiKerjaApproval->uuid)) {
            $Model->PenilaianPrestasiKerjaApproval->uuid = $uuid;
        }
        $Model->PenilaianPrestasiKerjaApproval->save();


        $PenilaianPrestasiKerja = PenilaianPrestasiKerja::where('id', $Model->PenilaianPrestasiKerjaApproval->penilaian_prestasi_kerja_id)
        ->with('jabatan')
        ->first();

        $jabatan_id = $PenilaianPrestasiKerja->jabatan->id;
        $is_staff = $PenilaianPrestasiKerja->jabatan->is_staff;
        $unit_kerja_id = $PenilaianPrestasiKerja->unit_kerja_id;

        if ($is_staff) {
          // ATASAN STAFF
          $user_penilai = User::where(function ($query) use($request) {
              $query->whereHas("jabatan", function ($query) use($request) {
                  $query->whereNull('is_staff');
              });
          })->where('unit_kerja_id', $unit_kerja_id)->with('jabatan')->first();
        } else {
            // ATASAN KEPALA
            // echo
            $jabatan_parent_id =  '';
            if (!empty($PenilaianPrestasiKerja['records']->user->jabatan->parent_id)) {
                $jabatan_parent_id = $PenilaianPrestasiKerja['records']->user->jabatan->parent_id;
            }

            // cetak($PenilaianPrestasiKerja['records']->user->jabatan->toArray());
            // die();
            $user_penilai = User::where('jabatan_id', $jabatan_parent_id)->first();

            // cetak($user_penilai);
            // die();
        }

        $user_atasan_penilai = null;
        if (!empty($user_penilai->jabatan->parent_id)) {
            $user_atasan_penilai = User::where('jabatan_id', $user_penilai->jabatan->parent_id)->first();
        }

        // jika di approve oleh atasan nya atasan
        if (!empty($user_atasan_penilai->id) && $user_atasan_penilai->id == Auth::user()->id) {
          $PenilaianPrestasiKerja = PenilaianPrestasiKerja::where('id', $Model->PenilaianPrestasiKerjaApproval->penilaian_prestasi_kerja_id)
            ->first();
          $PenilaianPrestasiKerja->status_approval_sdm = 'need_approval';
          $PenilaianPrestasiKerja->save();
        }

        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerjaApproval->id));
        return response()->json(Json::get(), 201);
    }

    public function Reject(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerjaApproval->save();

        $Model->PenilaianPrestasiKerjaReject->save();

        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerjaApproval->id));
        return response()->json(Json::get(), 201);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerjaApproval->delete();
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->get($QueryRoute);
        return $data->original['data']['records'];
    }
}
