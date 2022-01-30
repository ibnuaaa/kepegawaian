<?php

namespace App\Http\Middleware\UserJabatanFungsional;

use App\Models\UserJabatanFungsional;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserJabatanFungsional = UserJabatanFungsional::where('id', $this->Id)->first();
        if ($this->Model->UserJabatanFungsional) {
          if ($this->_Request->input('jabatan_fungsional_id')) $this->Model->UserJabatanFungsional->jabatan_fungsional_id = $this->_Request->input('jabatan_fungsional_id');
          if ($this->_Request->input('dari_tahun')) $this->Model->UserJabatanFungsional->dari_tahun = $this->_Request->input('dari_tahun');
          if ($this->_Request->input('sampai_tahun')) $this->Model->UserJabatanFungsional->sampai_tahun = $this->_Request->input('sampai_tahun');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->UserJabatanFungsional) {
            $this->Json::set('exception.key', 'NotFoundUserJabatanFungsional');
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
