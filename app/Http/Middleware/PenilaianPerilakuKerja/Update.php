<?php

namespace App\Http\Middleware\PenilaianPerilakuKerja;

use App\Models\PenilaianPerilakuKerja;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->PenilaianPerilakuKerja = PenilaianPerilakuKerja::where('id', $this->Id)->first();
        if ($this->Model->PenilaianPerilakuKerja) {
            $this->Model->PenilaianPerilakuKerja->name = $this->_Request->input('name');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required'
        ]);
        if (!$this->Model->PenilaianPerilakuKerja) {
            $this->Json::set('exception.key', 'NotFoundPenilaianPerilakuKerja');
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
