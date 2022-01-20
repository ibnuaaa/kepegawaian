<?php

namespace App\Http\Middleware\UserJabatan;

use App\Models\UserJabatan;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserJabatan = UserJabatan::where('id', $this->Id)->first();
        if ($this->Model->UserJabatan) {
          if ($this->_Request->input('jabatan_id')) $this->Model->UserJabatan->jabatan_id = $this->_Request->input('jabatan_id');
          if ($this->_Request->input('nama_jabatan')) $this->Model->UserJabatan->nama_jabatan = $this->_Request->input('nama_jabatan');
          if ($this->_Request->input('dari_tahun')) $this->Model->UserJabatan->dari_tahun = $this->_Request->input('dari_tahun');
          if ($this->_Request->input('sampai_tahun')) $this->Model->UserJabatan->sampai_tahun = $this->_Request->input('sampai_tahun');
          if ($this->_Request->input('unit_kerja_id')) $this->Model->UserJabatan->unit_kerja_id = $this->_Request->input('unit_kerja_id');
          if ($this->_Request->input('tmt')) $this->Model->UserJabatan->tmt = $this->_Request->input('tmt');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->UserJabatan) {
            $this->Json::set('exception.key', 'NotFoundUserJabatan');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.key')));
            return false;
        }
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
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
