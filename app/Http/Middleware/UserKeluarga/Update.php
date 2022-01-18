<?php

namespace App\Http\Middleware\UserKeluarga;

use App\Models\UserKeluarga;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserKeluarga = UserKeluarga::where('id', $this->Id)->first();
        if ($this->Model->UserKeluarga) {
          if ($this->_Request->input('pendidikan_id')) $this->Model->UserKeluarga->pendidikan_id = $this->_Request->input('pendidikan_id');
          if ($this->_Request->input('pendidikan_detail')) $this->Model->UserKeluarga->pendidikan_detail = $this->_Request->input('pendidikan_detail');
          if ($this->_Request->input('no_ijazah')) $this->Model->UserKeluarga->no_ijazah = $this->_Request->input('no_ijazah');
          if ($this->_Request->input('tahun_lulus')) $this->Model->UserKeluarga->tahun_lulus = $this->_Request->input('tahun_lulus');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required'
        ]);
        if (!$this->Model->UserKeluarga) {
            $this->Json::set('exception.key', 'NotFoundUserKeluarga');
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
