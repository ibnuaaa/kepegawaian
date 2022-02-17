<?php

namespace App\Http\Middleware\Pelatihan;

use App\Models\Pelatihan;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Pelatihan = new Pelatihan();

        $this->Model->Pelatihan->name = $this->_Request->input('name');
        $this->Model->Pelatihan->description = $this->_Request->input('description');
        $this->Model->Pelatihan->tanggal_mulai_pendaftaran = $this->_Request->input('tanggal_mulai_pendaftaran');
        $this->Model->Pelatihan->tanggal_selesai_pendaftaran = $this->_Request->input('tanggal_selesai_pendaftaran');
        $this->Model->Pelatihan->tanggal_mulai_pelatihan = $this->_Request->input('tanggal_mulai_pelatihan');
        $this->Model->Pelatihan->tanggal_selesai_pelatihan = $this->_Request->input('tanggal_selesai_pelatihan');
        $this->Model->Pelatihan->biaya = $this->_Request->input('biaya');
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
