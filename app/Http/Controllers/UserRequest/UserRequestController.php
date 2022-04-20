<?php

namespace App\Http\Controllers\UserRequest;

use App\Models\UserRequest;
use App\Models\User;

use App\Models\UserPendidikan;
use App\Models\UserPelatihan;
use App\Models\UserKeluarga;
use App\Models\UserJabatan;
use App\Models\UserJabatanFungsional;
use App\Models\UserGolongan;

use App\Models\UserPendidikanRequest;
use App\Models\UserPelatihanRequest;
use App\Models\UserKeluargaRequest;
use App\Models\UserJabatanRequest;
use App\Models\UserJabatanFungsionalRequest;
use App\Models\UserGolonganRequest;

use App\Models\Document;
use App\Models\UserRequestReject;


use App\Models\Position;
use App\Models\UserRequestCoupon;

use App\Traits\Browse;
use App\Traits\Artillery;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserRequestCoupon\UserRequestCouponBrowseController;

use App\Traits\UserRequest\UserRequestCollection;

class UserRequestController extends Controller
{
    use Artillery;
    use Browse, UserRequestCollection {
        UserRequestCollection::__construct as private __UserRequestCollectionConstruct;
    }

    protected $search = [
        'id',
        'username',
        'email',
        'updated_at',
        'created_at'
    ];
    public function get(Request $request)
    {
        $UserRequest = UserRequest::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->username)) {
                if ($request->ArrQuery->username === 'my') {
                    $query->where('username', $request->user()->username);
                } else {
                    $query->where('username', $request->ArrQuery->username);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                  $query->where('username', 'like', $search);
                  $query->orWhere('email', 'like', $search);
               } else {
                   $query->where(function ($query) use($search) {
                       foreach ($this->search as $key => $value) {
                           $query->orWhere($value, 'like', $search);
                       }
                   });
               }
           }
        });
        $Browse = $this->Browse($request, $UserRequest, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($UserRequest) {
                    return [ 'value' => $UserRequest->id, 'label' => $UserRequest->name ];
                });
            } else {
                $data->map(function($UserRequest) {
                    if (isset($UserRequest->point->balance)) {
                        $UserRequest->point->balance = (double)$UserRequest->point->balance;
                    }
                    return $UserRequest;
                });
            }
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UserRequest->password = Hash::make($Model->UserRequest->password);
        $Model->UserRequest->save();

        Json::set('data', $this->SyncData($request, $Model->UserRequest->id));
        return response()->json(Json::get(), 201);
    }


    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UserRequest->save();

        Json::set('data', $this->SyncData($request, $Model->UserRequest->id));
        return response()->json(Json::get(), 202);
    }


    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UserRequest->delete();
        return response()->json(Json::get(), 202);
    }

    public function ChangePassword(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UserRequest->password = app('hash')->make($request->input('new_password'));
        $Model->UserRequest->save();

        Json::set('data', $this->SyncData($request, $Model->UserRequest->id));
        return response()->json(Json::get(), 202);
    }

    public function ChangeStatus(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UserRequest->save();

        Json::set('data', $this->SyncData($request, $Model->UserRequest->id));
        return response()->json(Json::get(), 202);
    }

    public function CheckExist(Request $request)
    {



        $UserRequest = UserRequest::where('user_id', MyAccount()->id)
        ->orderBy('id','desc')
        ->first();

        // cetak($UserRequest);
        // die();

        // if ($UserRequest && ($UserRequest->status_sdm == 'request_approval' || $UserRequest->status_diklat == 'request_approval')) {
        //     Json::set('exception.code', 'NeedApprovalUser');
        //     Json::set('exception.message', trans('validation.'.Json::get('exception.code')));
        //     return response()->json(Json::get(), 400);
        // }

        $User = User::where('id', MyAccount()->id)->first();

        $isCreateNew = false;
        if (!$UserRequest || (!empty($UserRequest) && $UserRequest->status_sdm == 'approved' )) {
            $UserRequest = new UserRequest();
            $UserRequest->user_id = MyAccount()->id;
            $isCreateNew = true;
        }

        if ($isCreateNew) {
            $UserRequest->username  = $User->username;
            $UserRequest->email  = $User->email;
            $UserRequest->jabatan_id  = $User->jabatan_id;
            $UserRequest->jabatan_fungsional_id  = $User->jabatan_fungsional_id;
            $UserRequest->nip  = $User->nip;
            $UserRequest->no_ktp  = $User->no_ktp;
            $UserRequest->tanggal_lahir  = $User->tanggal_lahir;
            $UserRequest->tempat_lahir  = $User->tempat_lahir;
            $UserRequest->alamat  = $User->alamat;
            $UserRequest->kode_pos  = $User->kode_pos;
            $UserRequest->alamat_domisili  = $User->alamat_domisili;
            $UserRequest->kode_pos_domisili  = $User->kode_pos_domisili;
            $UserRequest->telepon  = $User->telepon;
            $UserRequest->hp  = $User->hp;
            $UserRequest->nama_kontak_darurat  = $User->nama_kontak_darurat;
            $UserRequest->hubungan_kontak_darurat  = $User->hubungan_kontak_darurat;
            $UserRequest->no_handphone_kontak_darurat  = $User->no_handphone_kontak_darurat;
            $UserRequest->no_str  = $User->no_str;
            $UserRequest->no_sip  = $User->no_sip;
            $UserRequest->masa_berlaku_str  = $User->masa_berlaku_str;
            $UserRequest->npwp  = $User->npwp;
            $UserRequest->no_rekening  = $User->no_rekening;
            $UserRequest->golongan_darah  = $User->golongan_darah;
            $UserRequest->status_perkawinan_id  = $User->status_perkawinan_id;
            $UserRequest->golongan_id  = $User->golongan_id;
            $UserRequest->status_pegawai_id  = $User->status_pegawai_id;
            $UserRequest->unit_kerja_id  = $User->unit_kerja_id;
            $UserRequest->pendidikan_id  = $User->pendidikan_id;
            $UserRequest->pendidikan_detail  = $User->pendidikan_detail;
            $UserRequest->status_sdm  = 'new';
            $UserRequest->save();

            $this->CopyDocumentToRequest('kk', $UserRequest, $User);
            $this->CopyDocumentToRequest('ktp', $UserRequest, $User);
            $this->CopyDocumentToRequest('npwp', $UserRequest, $User);
            $this->CopyDocumentToRequest('bpjs', $UserRequest, $User);
            $this->CopyDocumentToRequest('sip', $UserRequest, $User);
            $this->CopyDocumentToRequest('profile', $UserRequest, $User);
            $this->CopyDocumentToRequest('akta_nikah', $UserRequest, $User);


            $UserGolongan = UserGolongan::where('user_id', MyAccount()->id)->get();
            $UserJabatan = UserJabatan::where('user_id', MyAccount()->id)->get();
            $UserJabatanFungsional = UserJabatanFungsional::where('user_id', MyAccount()->id)->get();
            $UserKeluarga = UserKeluarga::where('user_id', MyAccount()->id)->get();
            $UserPelatihan = UserPelatihan::where('user_id', MyAccount()->id)->get();
            $UserPendidikan = UserPendidikan::where('user_id', MyAccount()->id)->get();

            // $UserGolonganRequest = UserGolonganRequest::where('user_id', MyAccount()->id)->delete();
            foreach ($UserGolongan as $key => $value) {
                $UserGolonganRequest = new UserGolonganRequest();
                $UserGolonganRequest->user_request_id = $UserRequest->id;
                $UserGolonganRequest->user_golongan_id = $value->id;
                $UserGolonganRequest->user_id = $value->user_id;
                $UserGolonganRequest->golongan_id = $value->golongan_id;
                $UserGolonganRequest->dari_tahun = $value->dari_tahun;
                $UserGolonganRequest->sampai_tahun = $value->sampai_tahun;
                $UserGolonganRequest->tmt = $value->tmt;
                $UserGolonganRequest->save();
            }

            // $UserJabatanRequest = UserJabatanRequest::where('user_id', MyAccount()->id)->delete();
            foreach ($UserJabatan as $key => $value) {
                $UserJabatanRequest = new UserJabatanRequest();
                $UserJabatanRequest->user_request_id = $UserRequest->id;
                $UserJabatanRequest->user_jabatan_id = $value->id;
                $UserJabatanRequest->user_id = $value->user_id;
                $UserJabatanRequest->jabatan_id = $value->jabatan_id;
                $UserJabatanRequest->detail_jabatan = $value->detail_jabatan;
                $UserJabatanRequest->dari_tahun = $value->dari_tahun;
                $UserJabatanRequest->sampai_tahun = $value->sampai_tahun;
                $UserJabatanRequest->unit_kerja_id = $value->unit_kerja_id;
                $UserJabatanRequest->tmt = $value->tmt;
                $UserJabatanRequest->save();
            }

            // $UserJabatanFungsionalRequest = UserJabatanFungsionalRequest::where('user_id', MyAccount()->id)->delete();
            foreach ($UserJabatanFungsional as $key => $value) {
                $UserJabatanFungsionalRequest = new UserJabatanFungsionalRequest();
                $UserJabatanFungsionalRequest->user_request_id = $UserRequest->id;
                $UserJabatanFungsionalRequest->user_jabatan_fungsional_id = $value->id;
                $UserJabatanFungsionalRequest->user_id = $value->user_id;
                $UserJabatanFungsionalRequest->jabatan_fungsional_id = $value->jabatan_fungsional_id;
                $UserJabatanFungsionalRequest->dari_tahun = $value->dari_tahun;
                $UserJabatanFungsionalRequest->sampai_tahun = $value->sampai_tahun;
                $UserJabatanFungsionalRequest->save();
            }


            // $UserKeluargaRequest = UserKeluargaRequest::where('user_id', MyAccount()->id)->delete();
            foreach ($UserKeluarga as $key => $value) {
                $UserKeluargaRequest = new UserKeluargaRequest();
                $UserKeluargaRequest->user_request_id = $UserRequest->id;
                $UserKeluargaRequest->user_keluarga_id = $value->id;
                $UserKeluargaRequest->user_id = $value->user_id;

                $UserKeluargaRequest->nama_lengkap =  $value->nama_lengkap;
                $UserKeluargaRequest->nik =  $value->nik;
                $UserKeluargaRequest->jenis_kelamin =  $value->jenis_kelamin;
                $UserKeluargaRequest->tempat_lahir =  $value->tempat_lahir;
                $UserKeluargaRequest->tanggal_lahir =  $value->tanggal_lahir;
                $UserKeluargaRequest->agama_id =  $value->agama_id;
                $UserKeluargaRequest->pendidikan_id =  $value->pendidikan_id;
                $UserKeluargaRequest->jenis_pekerjaan =  $value->jenis_pekerjaan;
                $UserKeluargaRequest->status_perkawinan =  $value->status_perkawinan;
                $UserKeluargaRequest->hubungan_keluarga =  $value->hubungan_keluarga;
                $UserKeluargaRequest->kewarganegaraan =  $value->kewarganegaraan;
                $UserKeluargaRequest->no_paspor =  $value->no_paspor;
                $UserKeluargaRequest->no_kitas =  $value->no_kitas;
                $UserKeluargaRequest->ayah =  $value->ayah;
                $UserKeluargaRequest->ibu =  $value->ibu;

                $UserKeluargaRequest->hub_keluarga_id =  $value->hub_keluarga_id;
                $UserKeluargaRequest->nip =  $value->nip;
                $UserKeluargaRequest->no_akta_nikah =  $value->no_akta_nikah;
                $UserKeluargaRequest->tgl_pernikahan =  $value->tgl_pernikahan;
                $UserKeluargaRequest->alamat =  $value->alamat;
                $UserKeluargaRequest->hp =  $value->hp;
                $UserKeluargaRequest->status_pasangan =  $value->status_pasangan;
                $UserKeluargaRequest->no_akta_cerai_meninggal =  $value->no_akta_cerai_meninggal;
                $UserKeluargaRequest->tgl_akta_cerai_meninggal =  $value->tgl_akta_cerai_meninggal;
                $UserKeluargaRequest->akta_kelahiran =  $value->akta_kelahiran;
                $UserKeluargaRequest->status_pekerjaan_id =  $value->status_pekerjaan_id;
                $UserKeluargaRequest->status_anak_id =  $value->status_anak_id;


                $UserKeluargaRequest->save();
            }


            // $UserPelatihanRequest = UserPelatihanRequest::where('user_id', MyAccount()->id)->delete();
            foreach ($UserPelatihan as $key => $value) {
                $UserPelatihanRequest = new UserPelatihanRequest();
                $UserPelatihanRequest->user_request_id = $UserRequest->id;
                $UserPelatihanRequest->user_pelatihan_id = $value->id;
                $UserPelatihanRequest->user_id = $value->user_id;
                $UserPelatihanRequest->nama_sertifikat = $value->nama_sertifikat;
                $UserPelatihanRequest->no_sertifikat = $value->no_sertifikat;
                $UserPelatihanRequest->tahun = $value->tahun;
                $UserPelatihanRequest->save();

                $this->CopyDocumentToRequest('sertifikat', $UserPelatihanRequest, $value);
            }

            // $UserPendidikanRequest = UserPendidikanRequest::where('user_id', MyAccount()->id)->delete();
            foreach ($UserPendidikan as $key => $value) {
                $UserPendidikanRequest = new UserPendidikanRequest();
                $UserPendidikanRequest->user_request_id = $UserRequest->id;
                $UserPendidikanRequest->user_pendidikan_id = $value->id;
                $UserPendidikanRequest->user_id = $value->user_id;
                $UserPendidikanRequest->pendidikan_id = $value->pendidikan_id;
                $UserPendidikanRequest->pendidikan_detail = $value->pendidikan_detail;
                $UserPendidikanRequest->fakultas = $value->fakultas;
                $UserPendidikanRequest->nim = $value->nim;
                $UserPendidikanRequest->tahun_lulus = $value->tahun_lulus;
                $UserPendidikanRequest->no_ijazah = $value->no_ijazah;
                $UserPendidikanRequest->save();

                $this->CopyDocumentToRequest('ijazah', $UserPendidikanRequest, $value);
                $this->CopyDocumentToRequest('transkrip_nilai', $UserPendidikanRequest, $value);


            }
        }

        Json::set('data', 'oke');
        return response()->json(Json::get(), 202);
    }


    public function Approve(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $UserRequest = UserRequest::where('id', $Model->UserRequest->id)->first();



        $User = User::where('id', $UserRequest->user_id)->first();
        $User->username  = $UserRequest->username;
        $User->email  = $UserRequest->email;
        $User->jabatan_id  = $UserRequest->jabatan_id;
        $User->jabatan_fungsional_id  = $UserRequest->jabatan_fungsional_id;
        $User->nip  = $UserRequest->nip;
        $User->no_ktp  = $UserRequest->no_ktp;
        $User->tanggal_lahir  = $UserRequest->tanggal_lahir;
        $User->tempat_lahir  = $UserRequest->tempat_lahir;
        $User->alamat  = $UserRequest->alamat;
        $User->kode_pos  = $UserRequest->kode_pos;
        $User->alamat_domisili  = $UserRequest->alamat_domisili;
        $User->kode_pos_domisili  = $UserRequest->kode_pos_domisili;
        $User->telepon  = $UserRequest->telepon;
        $User->hp  = $UserRequest->hp;
        $User->nama_kontak_darurat  = $UserRequest->nama_kontak_darurat;
        $User->hubungan_kontak_darurat  = $UserRequest->hubungan_kontak_darurat;
        $User->no_handphone_kontak_darurat  = $UserRequest->no_handphone_kontak_darurat;
        $User->npwp  = $UserRequest->npwp;
        $User->no_rekening  = $UserRequest->no_rekening;
        $User->golongan_darah  = $UserRequest->golongan_darah;
        $User->status_perkawinan_id  = $UserRequest->status_perkawinan_id;
        $User->golongan_id  = $UserRequest->golongan_id;
        $User->status_pegawai_id  = $UserRequest->status_pegawai_id;
        $User->no_str  = $UserRequest->no_str;
        $User->no_sip  = $UserRequest->no_sip;
        $User->masa_berlaku_str  = $UserRequest->masa_berlaku_str;
        $User->unit_kerja_id  = $UserRequest->unit_kerja_id;
        $User->pendidikan_id  = $UserRequest->pendidikan_id;
        $User->pendidikan_detail  = $UserRequest->pendidikan_detail;
        $User->gender  = $UserRequest->gender;
        $User->save();

        $this->updateDocumentAfterApprove('ktp', $User->id, $UserRequest);
        $this->updateDocumentAfterApprove('npwp', $User->id, $UserRequest);
        $this->updateDocumentAfterApprove('bpjs', $User->id, $UserRequest);
        $this->updateDocumentAfterApprove('sip', $User->id, $UserRequest);
        $this->updateDocumentAfterApprove('kk', $User->id, $UserRequest);
        // $this->updateDocumentAfterApprove('transkrip_nilai', $User->id, $UserRequest);
        $this->updateDocumentAfterApprove('akta_nikah', $User->id, $UserRequest);


        $this->updateDocumentAfterApprove('profile', $User->id, $UserRequest);

        if ($UserRequest) {
          $UserGolonganRequest = UserGolonganRequest::where('user_request_id', $UserRequest->id)->withTrashed()->get();
          $UserJabatanRequest = UserJabatanRequest::where('user_request_id', $UserRequest->id)->withTrashed()->get();
          $UserJabatanFungsionalRequest = UserJabatanFungsionalRequest::where('user_request_id', $UserRequest->id)->withTrashed()->get();
          $UserKeluargaRequest = UserKeluargaRequest::where('user_request_id', $UserRequest->id)->withTrashed()->get();
          $UserPelatihanRequest = UserPelatihanRequest::where('user_request_id', $UserRequest->id)->withTrashed()->get();
          $UserPendidikanRequest = UserPendidikanRequest::where('user_request_id', $UserRequest->id)->withTrashed()->get();



          if (!empty($request->input('status_sdm_approved')) && $request->input('status_sdm_approved') == 'y') {
              foreach ($UserGolonganRequest as $key => $value) {

                  if ($value->deleted_at) {
                      $UserGolongan = UserGolongan::where('id', $value->user_golongan_id)->delete();
                      continue;
                  }

                  $UserGolongan = UserGolongan::where('id', $value->user_golongan_id)->first();
                  if (!$UserGolongan) {
                    $UserGolongan = new UserGolongan();
                  }
                  $UserGolongan->user_id = $value->user_id;
                  $UserGolongan->golongan_id = $value->golongan_id;
                  $UserGolongan->dari_tahun = $value->dari_tahun;
                  $UserGolongan->sampai_tahun = $value->sampai_tahun;
                  $UserGolongan->tmt = $value->tmt;
                  $UserGolongan->save();


              }

              foreach ($UserJabatanRequest as $key => $value) {

                  if ($value->deleted_at) {
                      $UserJabatan = UserJabatan::where('id', $value->user_jabatan_id)->delete();
                      continue;
                  }
                  $UserJabatan = UserJabatan::where('id', $value->user_jabatan_id)->first();

                  if (!$UserJabatan) {
                    $UserJabatan = new UserJabatan();
                  }
                  $UserJabatan->user_id = $value->user_id;
                  $UserJabatan->jabatan_id = $value->jabatan_id;
                  $UserJabatan->detail_jabatan = $value->detail_jabatan;
                  $UserJabatan->dari_tahun = $value->dari_tahun;
                  $UserJabatan->sampai_tahun = $value->sampai_tahun;
                  $UserJabatan->unit_kerja_id = $value->unit_kerja_id;
                  $UserJabatan->tmt = $value->tmt;
                  $UserJabatan->save();


              }

              foreach ($UserJabatanFungsionalRequest as $key => $value) {

                  if ($value->deleted_at) {
                      $UserJabatanFungsional = UserJabatanFungsional::where('id', $value->user_jabatan_fungsional_id)->delete();
                      continue;
                  }
                  $UserJabatanFungsional = UserJabatanFungsional::where('id', $value->user_jabatan_fungsional_id)->first();

                  if (!$UserJabatanFungsional) {
                    $UserJabatanFungsional = new UserJabatanFungsional();
                  }
                  $UserJabatanFungsional->user_id = $value->user_id;
                  $UserJabatanFungsional->jabatan_fungsional_id = $value->jabatan_fungsional_id;
                  $UserJabatanFungsional->dari_tahun = $value->dari_tahun;
                  $UserJabatanFungsional->sampai_tahun = $value->sampai_tahun;
                  $UserJabatanFungsional->save();


              }


              foreach ($UserKeluargaRequest as $key => $value) {

                  if ($value->deleted_at) {
                      $UserKeluarga = UserKeluarga::where('id', $value->user_keluarga_id)->delete();
                      continue;
                  }
                  $UserKeluarga = UserKeluarga::where('id', $value->user_keluarga_id)->first();

                  if (!$UserKeluarga) {
                    $UserKeluarga = new UserKeluarga();
                  }
                  $UserKeluarga->user_id = $value->user_id;

                  $UserKeluarga->nama_lengkap =  $value->nama_lengkap;
                  $UserKeluarga->nik =  $value->nik;
                  $UserKeluarga->jenis_kelamin =  $value->jenis_kelamin;
                  $UserKeluarga->tempat_lahir =  $value->tempat_lahir;
                  $UserKeluarga->tanggal_lahir =  $value->tanggal_lahir;
                  $UserKeluarga->agama_id =  $value->agama_id;
                  $UserKeluarga->pendidikan_id =  $value->pendidikan_id;
                  $UserKeluarga->jenis_pekerjaan =  $value->jenis_pekerjaan;
                  $UserKeluarga->status_perkawinan =  $value->status_perkawinan;
                  $UserKeluarga->hubungan_keluarga =  $value->hubungan_keluarga;
                  $UserKeluarga->kewarganegaraan =  $value->kewarganegaraan;
                  $UserKeluarga->no_paspor =  $value->no_paspor;
                  $UserKeluarga->no_kitas =  $value->no_kitas;
                  $UserKeluarga->ayah =  $value->ayah;
                  $UserKeluarga->ibu =  $value->ibu;

                  $UserKeluarga->hub_keluarga_id =  $value->hub_keluarga_id;
                  $UserKeluarga->nip =  $value->nip;
                  $UserKeluarga->no_akta_nikah =  $value->no_akta_nikah;
                  $UserKeluarga->tgl_pernikahan =  $value->tgl_pernikahan;
                  $UserKeluarga->alamat =  $value->alamat;
                  $UserKeluarga->hp =  $value->hp;
                  $UserKeluarga->status_pasangan =  $value->status_pasangan;
                  $UserKeluarga->no_akta_cerai_meninggal =  $value->no_akta_cerai_meninggal;
                  $UserKeluarga->tgl_akta_cerai_meninggal =  $value->tgl_akta_cerai_meninggal;
                  $UserKeluarga->akta_kelahiran =  $value->akta_kelahiran;
                  $UserKeluarga->status_pekerjaan_id =  $value->status_pekerjaan_id;
                  $UserKeluarga->status_anak_id =  $value->status_anak_id;


                  $UserKeluarga->save();

              }


          } else if (!empty($request->input('status_diklat_approved')) && $request->input('status_diklat_approved') == 'y') {

              foreach ($UserPelatihanRequest as $key => $value) {

                  if ($value->deleted_at) {
                      $UserPelatihan = UserPelatihan::where('id', $value->user_pelatihan_id)->delete();
                      continue;
                  }
                  $UserPelatihan = UserPelatihan::where('id', $value->user_pelatihan_id)->first();

                  if (!$UserPelatihan) {
                    $UserPelatihan = new UserPelatihan();
                  }
                  $UserPelatihan->user_id = $value->user_id;
                  $UserPelatihan->nama_sertifikat = $value->nama_sertifikat;
                  $UserPelatihan->no_sertifikat = $value->no_sertifikat;
                  $UserPelatihan->tahun = $value->tahun;
                  $UserPelatihan->save();

                  $this->updateDocumentAfterApprove('sertifikat', $UserPelatihan->id, $value);
              }



              foreach ($UserPendidikanRequest as $key => $value) {



                  if ($value->deleted_at) {
                      $UserPendidikan = UserPendidikan::where('id', $value->user_pendidikan_id)->delete();
                      continue;
                  }
                  $UserPendidikan = UserPendidikan::where('id', $value->user_pendidikan_id)->first();

                  if (!$UserPendidikan) {
                    $UserPendidikan = new UserPendidikan();
                  }
                  $UserPendidikan->user_id = $value->user_id;
                  $UserPendidikan->pendidikan_id = $value->pendidikan_id;
                  $UserPendidikan->pendidikan_detail = $value->pendidikan_detail;
                  $UserPendidikan->fakultas = $value->fakultas;
                  $UserPendidikan->nim = $value->nim;
                  $UserPendidikan->no_ijazah = $value->no_ijazah;
                  $UserPendidikan->tahun_lulus = $value->tahun_lulus;
                  $UserPendidikan->save();


                  $this->updateDocumentAfterApprove('ijazah', $UserPendidikan->id, $value);
                  $this->updateDocumentAfterApprove('transkrip_nilai', $UserPendidikan->id, $value);

              }
          }
        }

        $Model->UserRequest->save();

        Json::set('data', 'oke');
        return response()->json(Json::get(), 202);
    }

    public function Reject(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UserRequest->save();

        $UserRequestReject = new UserRequestReject();
        $UserRequestReject->user_request_id = $Model->UserRequest->id;
        $UserRequestReject->description = $request->input('description');
        $UserRequestReject->reject_user_id = MyAccount()->id;
        $UserRequestReject->status = 'rejected';
        $UserRequestReject->save();

        Json::set('data', 'oke');
        return response()->json(Json::get(), 202);
    }

    public function RequestApproval(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $user_request = UserRequest::where('user_id', MyAccount()->id)
          ->where(function ($query) use($request) {
              $query->where('status_sdm', 'new');
              $query->orWhere('status_sdm', 'rejected');
              $query->orWhere('status_diklat', 'rejected');
          })
          ->orderBy('id', 'DESC')->first();

        $user_golongan_request = UserGolonganRequest::where('user_request_id', $user_request->id)->first();
        $user_jabatan_request = UserJabatanRequest::where('user_request_id', $user_request->id)->first();
        $user_jabatan_fungsional_request = UserJabatanFungsionalRequest::where('user_request_id', $user_request->id)->first();
        $user_keluarga_request = UserKeluargaRequest::where('user_request_id', $user_request->id)->first();
        $user_pelatihan_request = UserPelatihanRequest::where('user_request_id', $user_request->id)->first();
        $user_pendidikan_request = UserPendidikanRequest::where('user_request_id', $user_request->id)->first();


        UserRequestReject::where('user_request_id', $user_request->id)->update([
            'status' => 'requested'
        ]);

        $message  = [];

        if (empty($user_golongan_request)) {
          // $message[] = "Riwayat Golongan Harus Diisi";
        }

        if (empty($user_jabatan_request)) {
          // $message[] = "Riwayat Jabatan Harus Diisi";
        }

        if (empty($user_jabatan_fungsional_request)) {
          // $message[] = "Riwayat Jabatan Fungsional Harus Diisi";
        }

        if (empty($user_keluarga_request)) {
          // $message[] = "Data Keluarga Harus Diisi";
        }

        if (empty($user_pelatihan_request)) {
          // $message[] = "Riwayat Pelatihan Harus Diisi";
        }

        if (empty($user_pendidikan_request)) {
          // $message[] = "Riwayat Pendidikan Harus Diisi";
        }

        if (count($message) > 0) {
            Json::set('exception.message', implode('
            ',$message));
            return response()->json(Json::get(), 400);
        }
        $Model->UserRequest->save();

        Json::set('data', 'oke');
        return response()->json(Json::get(), 202);
    }

    public function updateDocumentAfterApprove($object, $object_id, $value) {
        $DocumentRequest = Document::where('object', 'foto_'.$object.'_request')->where('object_id', $value->id)->orderBy('id', 'DESC')->first();
        $Document = Document::where('object', 'foto_' . $object)->where('object_id', $object_id)->orderBy('id', 'DESC')->first();

        if (!empty($DocumentRequest->storage_id) || empty($object_id)) {

            if ($object_id) Document::where('object', 'foto_' . $object)->where('object_id', $object_id)->delete();

            $Document = new Document();
            $Document->object = 'foto_' . $object;
            $Document->object_id = $object_id;
            $Document->storage_id = $DocumentRequest->storage_id;
            $Document->save();
        }
    }

    public function CopyDocumentToRequest($object, $valueRequest, $value) {
        $Document = Document::where('object', 'foto_' . $object)->where('object_id', $value->id)->orderBy('id', 'desc')->first();

        if ($Document) {
          $DocumentRequest = new Document();
          $DocumentRequest->object = 'foto_' . $object . '_request';
          $DocumentRequest->object_id = $valueRequest->id;
          $DocumentRequest->storage_id = $Document->storage_id;
          $DocumentRequest->save();
        }
    }

    public function ResetPassword(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $data['new_pass'] = $Model->UserRequest->password;

        $Model->UserRequest->password = Hash::make($Model->UserRequest->password);
        $Model->UserRequest->save();

        Json::set('data', $data);
        return response()->json(Json::get(), 202);
    }

    public function DeveloperToken(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        Json::set('data', [
            'token_type' => 'Bearer',
            'access_token' => $Model->UserRequest->createToken('ServiceAccessToken', ['blast'])->accessToken
        ]);
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
