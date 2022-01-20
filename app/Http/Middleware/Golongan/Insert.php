<?php

namespace App\Http\Middleware\Golongan;

use App\Models\Golongan;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Golongan = new Golongan();

        $this->Model->Golongan->pangkat = $this->_Request->input('pangkat');
        $this->Model->Golongan->golongan = $this->_Request->input('golongan');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
          'pangkat' => 'required',
          'golongan' => 'required'
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if ($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
