<?php

namespace App\Http\Middleware\UserRequest;

use App\Models\UserRequest;
use App\Models\Position;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {

        if ($this->Id == 'my') {
           $this->Id = MyAccount()->id;
        }

        $this->Model->UserRequest = UserRequest::where('user_id', $this->Id)
          ->where(function ($query) use($request) {
              $query->whereIn('status_sdm', ['new','request_approval']);
            //   $query->where('status_sdm', 'new');
              $query->orWhere('status_sdm', 'rejected');
              $query->orWhere('status_diklat', 'rejected');
          })
          ->orderBy('id', 'desc')->first();

        $this->Model->User = User::where('email', $this->_Request->input('email'))->where('id', '!=', $this->Model->UserRequest->user_id)->first();


        $password = $this->_Request->input('password');
        if (Hash::needsRehash($this->_Request->input('password'))) {
            $password = app('hash')->make($password);
        }
        if ($this->Model->UserRequest) {

            !$this->_Request->input('username') || $this->Model->UserRequest->username = $this->_Request->input('username');
            !$this->_Request->input('email') || $this->Model->UserRequest->email = $this->_Request->input('email');
            !$this->_Request->input('name') || $this->Model->UserRequest->name = $this->_Request->input('name');
            !$this->_Request->input('address') || $this->Model->UserRequest->address = $this->_Request->input('address');
            !$this->_Request->input('position_id') || $this->Model->UserRequest->position_id = $this->_Request->input('position_id');
            !$this->_Request->input('jabatan_id') || $this->Model->UserRequest->jabatan_id = $this->_Request->input('jabatan_id');
            !$this->_Request->input('jabatan_fungsional_id') || $this->Model->UserRequest->jabatan_fungsional_id = $this->_Request->input('jabatan_fungsional_id');
            !$this->_Request->input('nip') || $this->Model->UserRequest->nip = $this->_Request->input('nip');

            !$this->_Request->input('no_ktp') || $this->Model->UserRequest->no_ktp = $this->_Request->input('no_ktp');
            !$this->_Request->input('tanggal_lahir') || $this->Model->UserRequest->tanggal_lahir = $this->_Request->input('tanggal_lahir');
            !$this->_Request->input('tempat_lahir') || $this->Model->UserRequest->tempat_lahir = $this->_Request->input('tempat_lahir');
            !$this->_Request->input('alamat') || $this->Model->UserRequest->alamat = $this->_Request->input('alamat');
            !$this->_Request->input('kode_pos') || $this->Model->UserRequest->kode_pos = $this->_Request->input('kode_pos');
            !$this->_Request->input('alamat_domisili') || $this->Model->UserRequest->alamat_domisili = $this->_Request->input('alamat_domisili');
            !$this->_Request->input('kode_pos_domisili') || $this->Model->UserRequest->kode_pos_domisili = $this->_Request->input('kode_pos_domisili');
            !$this->_Request->input('telepon') || $this->Model->UserRequest->telepon = $this->_Request->input('telepon');
            !$this->_Request->input('hp') || $this->Model->UserRequest->hp = $this->_Request->input('hp');
            !$this->_Request->input('npwp') || $this->Model->UserRequest->npwp = $this->_Request->input('npwp');
            !$this->_Request->input('no_rekening') || $this->Model->UserRequest->no_rekening = $this->_Request->input('no_rekening');
            !$this->_Request->input('golongan_darah') || $this->Model->UserRequest->golongan_darah = $this->_Request->input('golongan_darah');
            !$this->_Request->input('status_perkawinan_id') || $this->Model->UserRequest->status_perkawinan_id = $this->_Request->input('status_perkawinan_id');
            !$this->_Request->input('golongan_id') || $this->Model->UserRequest->golongan_id = $this->_Request->input('golongan_id');
            !$this->_Request->input('unit_kerja_id') || $this->Model->UserRequest->unit_kerja_id = $this->_Request->input('unit_kerja_id');
            !$this->_Request->input('status_pegawai_id') || $this->Model->UserRequest->status_pegawai_id = $this->_Request->input('status_pegawai_id');
            !$this->_Request->input('pendidikan_id') || $this->Model->UserRequest->pendidikan_id = $this->_Request->input('pendidikan_id');
            !$this->_Request->input('pendidikan_detail') || $this->Model->UserRequest->pendidikan_detail = $this->_Request->input('pendidikan_detail');
            !$this->_Request->input('gender') || $this->Model->UserRequest->gender = $this->_Request->input('gender');
            !$this->_Request->input('no_str') || $this->Model->UserRequest->no_str = $this->_Request->input('no_str');
            !$this->_Request->input('masa_berlaku_str') || $this->Model->UserRequest->masa_berlaku_str = $this->_Request->input('masa_berlaku_str');
            !$this->_Request->input('no_sip') || $this->Model->UserRequest->no_sip = $this->_Request->input('no_sip');



            if ($this->_Request->input('password')) {
                $this->Model->UserRequest->password = $password;
            }
            if ($this->_Request->input('position_id')) {
                $this->Model->Position = Position::where('id', $this->Model->UserRequest->position_id)->first();
            }

        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'username' => ['unique:users,username,'.$this->Id, 'max:255'],
            'email' => ['max:255'],
            'password' => 'min:6|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'position_id' => [],
            'gender' => ['in:male,female'],
        ]);
        if (!$this->Model->UserRequest) {
            $this->Json::set('exception.code', 'NotFoundUserRequest');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if ($this->_Request->input('project_id') && !$this->Model->Position) {
            $this->Json::set('exception.code', 'NotFoundPosition');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }
        if ($this->Model->User) {
            $this->Json::set('exception.code', 'UserDuplicate');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }

        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate($request);
        if ($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
