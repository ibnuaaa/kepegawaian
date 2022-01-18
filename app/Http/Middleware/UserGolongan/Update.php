<?php

namespace App\Http\Middleware\UserGolongan;

use App\Models\UserGolongan;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserGolongan = UserGolongan::where('id', $this->Id)->first();
        if ($this->Model->UserGolongan) {
          if ($this->_Request->input('golongan_id')) $this->Model->UserGolongan->golongan_id = $this->_Request->input('golongan_id');
          if ($this->_Request->input('dari_tahun')) $this->Model->UserGolongan->dari_tahun = $this->_Request->input('dari_tahun');
          if ($this->_Request->input('sampai_tahun')) $this->Model->UserGolongan->sampai_tahun = $this->_Request->input('sampai_tahun');
          if ($this->_Request->input('tmt')) $this->Model->UserGolongan->tmt = $this->_Request->input('tmt');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->UserGolongan) {
            $this->Json::set('exception.key', 'NotFoundUserGolongan');
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
