<?php

namespace App\Http\Middleware\UserJabatanRequest;

use App\Models\UserJabatanRequest;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserJabatanRequest = UserJabatanRequest::where('id', $this->Id)->first();
        if ($this->Model->UserJabatanRequest) {
          if ($this->_Request->input('jabatan_id')) $this->Model->UserJabatanRequest->jabatan_id = $this->_Request->input('jabatan_id');
          if ($this->_Request->input('nama_jabatan')) $this->Model->UserJabatanRequest->nama_jabatan = $this->_Request->input('nama_jabatan');
          if ($this->_Request->input('dari_tahun')) $this->Model->UserJabatanRequest->dari_tahun = $this->_Request->input('dari_tahun');
          if ($this->_Request->input('sampai_tahun')) $this->Model->UserJabatanRequest->sampai_tahun = $this->_Request->input('sampai_tahun');
          if ($this->_Request->input('unit_kerja_id')) $this->Model->UserJabatanRequest->unit_kerja_id = $this->_Request->input('unit_kerja_id');
          if ($this->_Request->input('tmt')) $this->Model->UserJabatanRequest->tmt = $this->_Request->input('tmt');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->UserJabatanRequest) {
            $this->Json::set('exception.key', 'NotFoundUserJabatanRequest');
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
