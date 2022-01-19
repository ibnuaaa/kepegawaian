<?php

namespace App\Http\Middleware\Jabatan;

use App\Models\Jabatan;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Delete extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Jabatan = Jabatan::find($this->Id);
    }

    private function Validation()
    {
        if (!$this->Model->Jabatan) {
            $this->Json::set('exception.code', 'NotFoundJabatan');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
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
