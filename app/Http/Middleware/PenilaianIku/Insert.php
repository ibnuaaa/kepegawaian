<?php

namespace App\Http\Middleware\PenilaianIku;

use App\Models\PenilaianIku;
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
        $this->Model->PenilaianIku = new PenilaianIku();

        $this->Model->PenilaianIku->user_id = MyAccount()->id;
        $this->Model->PenilaianIku->bulan = date('m');
        $this->Model->PenilaianIku->tahun = date('Y');


        $this->Model->PenilaianIku->jabatan_id = MyAccount()->jabatan_id;
        $this->Model->PenilaianIku->jabatan_fungsional_id = MyAccount()->jabatan_fungsional_id;
        $this->Model->PenilaianIku->unit_kerja_id = MyAccount()->unit_kerja_id;

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
