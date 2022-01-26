<?php

namespace App\Http\Middleware\Golongan;

use App\Models\Golongan;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->Golongan = Golongan::where('id', $this->Id)->first();
        if ($this->Model->Golongan) {
            $this->Model->Golongan->pangkat = $this->_Request->input('pangkat');
            $this->Model->Golongan->golongan = $this->_Request->input('golongan');
      }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
          'pangkat' => 'required',
          'golongan' => 'required'
        ]);
        if (!$this->Model->Golongan) {
            $this->Json::set('exception.key', 'NotFoundGolongan');
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
