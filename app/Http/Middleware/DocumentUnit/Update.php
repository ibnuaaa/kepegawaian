<?php

namespace App\Http\Middleware\DocumentUnit;

use App\Models\DocumentUnit;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->DocumentUnit = DocumentUnit::where('id', $this->Id)->first();
        if ($this->Model->DocumentUnit) {
            if(!empty($this->_Request->input('name'))) $this->Model->DocumentUnit->name = $this->_Request->input('name');
            if(!empty($this->_Request->input('name'))) $this->Model->DocumentUnit->description = $this->_Request->input('description');
            if(!empty($this->_Request->input('name'))) $this->Model->DocumentUnit->unit_kerja_id = $this->_Request->input('unit_kerja_id');
            if(!empty($this->_Request->input('name'))) $this->Model->DocumentUnit->tanggal_terbit_dokumen = $this->_Request->input('tanggal_terbit_dokumen');
            if(!empty($this->_Request->input('name'))) $this->Model->DocumentUnit->no_dokumen = $this->_Request->input('no_dokumen');
            if(!empty($this->_Request->input('name'))) $this->Model->DocumentUnit->perspektif_id = $this->_Request->input('perspektif_id')
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required'
        ]);
        if (!$this->Model->DocumentUnit) {
            $this->Json::set('exception.key', 'NotFoundDocumentUnit');
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
