<?php

namespace App\Http\Middleware\PenilaianPrestasiKerja;

use App\Models\PenilaianPrestasiKerja;
use App\Models\PerilakuKerja;
use App\Models\Jabatan;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->PenilaianPrestasiKerja = new PenilaianPrestasiKerja();

        $this->Model->PenilaianPrestasiKerja->user_id = MyAccount()->id;
        $this->Model->PenilaianPrestasiKerja->bulan = date('m');
        $this->Model->PenilaianPrestasiKerja->tahun = date('Y');


        $this->Model->PenilaianPrestasiKerja->jabatan_id = MyAccount()->jabatan_id;
        $this->Model->PenilaianPrestasiKerja->unit_kerja_id = MyAccount()->unit_kerja_id;

    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
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
