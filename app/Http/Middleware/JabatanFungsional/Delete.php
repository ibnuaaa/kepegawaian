<?php

namespace App\Http\Middleware\JabatanFungsional;

use App\Models\JabatanFungsional;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Delete extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->JabatanFungsional = JabatanFungsional::find($this->Id);
    }

    private function Validation()
    {
        $validator = Validator::make([ 'id' => $this->Id ], $this->Rules);
        if (!$this->Model->JabatanFungsional) {
            $this->Json::set('exception.code', 'NotFoundJabatanFungsional');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
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
