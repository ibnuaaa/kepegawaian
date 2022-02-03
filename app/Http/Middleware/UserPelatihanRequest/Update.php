<?php

namespace App\Http\Middleware\UserPelatihanRequest;

use App\Models\UserPelatihanRequest;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserPelatihanRequest = UserPelatihanRequest::where('id', $this->Id)->first();
        if ($this->Model->UserPelatihanRequest) {
          if ($this->_Request->input('nama_sertifikat')) $this->Model->UserPelatihanRequest->nama_sertifikat = $this->_Request->input('nama_sertifikat');
          if ($this->_Request->input('no_sertifikat')) $this->Model->UserPelatihanRequest->no_sertifikat = $this->_Request->input('no_sertifikat');
          if ($this->_Request->input('tahun')) $this->Model->UserPelatihanRequest->tahun = $this->_Request->input('tahun');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->UserPelatihanRequest) {
            $this->Json::set('exception.key', 'NotFoundUserPelatihanRequest');
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
