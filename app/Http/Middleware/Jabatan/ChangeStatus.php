<?php

namespace App\Http\Middleware\Jabatan;

use App\Models\Jabatan;
use App\Models\Blast\Category;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class ChangeStatus extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->Jabatan = Jabatan::where('id', $this->_Request->input('jabatan_id'))->first();
        if ($this->Model->Jabatan) {
            $this->Model->Jabatan->status = $this->_Request->input('status');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'status' => ['in:active,inactive']
        ]);
        if (!$this->Model->Jabatan) {
            $this->Json::set('exception.code', 'NotFoundJabatan');
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
