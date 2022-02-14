<?php

namespace App\Http\Middleware\DocumentUnit;

use App\Models\DocumentUnit;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->DocumentUnit = new DocumentUnit();

        $this->Model->DocumentUnit->name = $this->_Request->input('name');
        $this->Model->DocumentUnit->description = $this->_Request->input('description');
        $this->Model->DocumentUnit->unit_kerja_id = $this->_Request->input('unit_kerja_id');
        $this->Model->DocumentUnit->tanggal_terbit_dokumen = $this->_Request->input('tanggal_terbit_dokumen');
        $this->Model->DocumentUnit->no_dokumen = $this->_Request->input('no_dokumen');
        $this->Model->DocumentUnit->perspektif_id = $this->_Request->input('perspektif_id');
        $this->Model->DocumentUnit->jenis_dokumen_id = $this->_Request->input('jenis_dokumen_id');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required'
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
