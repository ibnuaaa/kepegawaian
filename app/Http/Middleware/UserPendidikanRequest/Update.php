<?php

namespace App\Http\Middleware\UserPendidikanRequest;

use App\Models\UserPendidikanRequest;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserPendidikanRequest = UserPendidikanRequest::where('id', $this->Id)->first();
        if ($this->Model->UserPendidikanRequest) {
          if ($this->_Request->input('pendidikan_id')) $this->Model->UserPendidikanRequest->pendidikan_id = $this->_Request->input('pendidikan_id');
          if ($this->_Request->input('pendidikan_detail')) $this->Model->UserPendidikanRequest->pendidikan_detail = $this->_Request->input('pendidikan_detail');
          if ($this->_Request->input('kampus_id')) $this->Model->UserPendidikanRequest->kampus_id = $this->_Request->input('kampus_id');
          if ($this->_Request->input('fakultas')) $this->Model->UserPendidikanRequest->fakultas = $this->_Request->input('fakultas');
          if ($this->_Request->input('nim')) $this->Model->UserPendidikanRequest->nim = $this->_Request->input('nim');
          if ($this->_Request->input('no_ijazah')) $this->Model->UserPendidikanRequest->no_ijazah = $this->_Request->input('no_ijazah');
          if ($this->_Request->input('tahun_lulus')) $this->Model->UserPendidikanRequest->tahun_lulus = $this->_Request->input('tahun_lulus');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->UserPendidikanRequest) {
            $this->Json::set('exception.key', 'NotFoundUserPendidikanRequest');
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
