<?php

namespace App\Http\Middleware\User;

use App\Models\User;
use App\Models\Position;
use App\Models\Blast\Category;

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

        $this->Model->User = User::where('id', $this->Id)->first();
        $password = $this->_Request->input('password');
        if (Hash::needsRehash($this->_Request->input('password'))) {
            $password = app('hash')->make($password);
        }
        if ($this->Model->User) {
            !$this->_Request->input('username') || $this->Model->User->username = $this->_Request->input('username');
            !$this->_Request->input('name') || $this->Model->User->name = $this->_Request->input('name');
            !$this->_Request->input('address') || $this->Model->User->address = $this->_Request->input('address');
            !$this->_Request->input('position_id') || $this->Model->User->position_id = $this->_Request->input('position_id');
            !$this->_Request->input('jabatan_id') || $this->Model->User->jabatan_id = $this->_Request->input('jabatan_id');
            !$this->_Request->input('jabatan_fungsional_id') || $this->Model->User->jabatan_fungsional_id = $this->_Request->input('jabatan_fungsional_id');
            !$this->_Request->input('nip') || $this->Model->User->nip = $this->_Request->input('nip');

            !$this->_Request->input('no_ktp') || $this->Model->User->no_ktp = $this->_Request->input('no_ktp');
            !$this->_Request->input('no_str') || $this->Model->User->no_ktp = $this->_Request->input('no_ktp');
            !$this->_Request->input('no_ktp') || $this->Model->User->no_ktp = $this->_Request->input('no_ktp');
            !$this->_Request->input('tanggal_lahir') || $this->Model->User->tanggal_lahir = $this->_Request->input('tanggal_lahir');
            !$this->_Request->input('tempat_lahir') || $this->Model->User->tempat_lahir = $this->_Request->input('tempat_lahir');
            !$this->_Request->input('alamat') || $this->Model->User->alamat = $this->_Request->input('alamat');
            !$this->_Request->input('kode_pos') || $this->Model->User->kode_pos = $this->_Request->input('kode_pos');
            !$this->_Request->input('telepon') || $this->Model->User->telepon = $this->_Request->input('telepon');
            !$this->_Request->input('hp') || $this->Model->User->hp = $this->_Request->input('hp');
            !$this->_Request->input('npwp') || $this->Model->User->npwp = $this->_Request->input('npwp');
            !$this->_Request->input('no_rekening') || $this->Model->User->no_rekening = $this->_Request->input('no_rekening');
            !$this->_Request->input('golongan_darah') || $this->Model->User->golongan_darah = $this->_Request->input('golongan_darah');
            !$this->_Request->input('status_perkawinan_id') || $this->Model->User->status_perkawinan_id = $this->_Request->input('status_perkawinan_id');
            !$this->_Request->input('golongan_id') || $this->Model->User->golongan_id = $this->_Request->input('golongan_id');
            !$this->_Request->input('unit_kerja_id') || $this->Model->User->unit_kerja_id = $this->_Request->input('unit_kerja_id');
            !$this->_Request->input('pendidikan_id') || $this->Model->User->pendidikan_id = $this->_Request->input('pendidikan_id');
            !$this->_Request->input('pendidikan_detail') || $this->Model->User->pendidikan_detail = $this->_Request->input('pendidikan_detail');
            !$this->_Request->input('gender') || $this->Model->User->gender = $this->_Request->input('gender');
            !$this->_Request->input('no_str') || $this->Model->User->no_str = $this->_Request->input('no_str');
            !$this->_Request->input('masa_berlaku_str') || $this->Model->User->masa_berlaku_str = $this->_Request->input('masa_berlaku_str');
            !$this->_Request->input('status_pegawai_id') || $this->Model->User->status_pegawai_id = $this->_Request->input('status_pegawai_id');

            if ($this->_Request->input('password')) {
                $this->Model->User->password = $password;
            }
            if ($this->_Request->input('position_id')) {
                $this->Model->Position = Position::where('id', $this->Model->User->position_id)->first();
            }

        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'username' => ['unique:users,username,'.$this->Id, 'max:255'],
            'email' => ['unique:users,email,'.$this->Id, 'max:255'],
            'password' => 'min:6|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'position_id' => [],
            'gender' => ['in:male,female'],
        ]);
        if (!$this->Model->User) {
            $this->Json::set('exception.code', 'NotFoundUser');
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
