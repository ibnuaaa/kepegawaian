<?php

namespace App\Http\Middleware\IndikatorTetap;

use App\Models\IndikatorTetap;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->IndikatorTetap = IndikatorTetap::where('id', $this->Id)->first();
        if ($this->Model->IndikatorTetap) {
          $this->Model->IndikatorTetap->name = $this->_Request->input('name');
          $this->Model->IndikatorTetap->type = $this->_Request->input('type');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required'
        ]);
        if (!$this->Model->IndikatorTetap) {
            $this->Json::set('exception.key', 'NotFoundIndikatorTetap');
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
