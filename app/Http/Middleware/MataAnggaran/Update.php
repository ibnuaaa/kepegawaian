<?php

namespace App\Http\Middleware\MataAnggaran;

use App\Models\MataAnggaran;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->MataAnggaran = MataAnggaran::find($this->Id);

        if ($this->Model->MataAnggaran) {
            $this->Model->MataAnggaran->name = $this->_Request->input('name');
            $this->Model->MataAnggaran->unit_kerja_id = $this->_Request->input('unit_kerja_id');
            $this->Model->MataAnggaran->code = $this->_Request->input('code');

            if($this->_Request->input('parent_id')) $this->Model->MataAnggaran->parent_id = $this->_Request->input('parent_id');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if (!$this->Model->MataAnggaran) {
            $this->Json::set('exception.code', 'NotFoundMataAnggaran');
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
