<?php

namespace App\Http\Middleware\PenilaianLogbook;

use App\Models\PenilaianLogbook;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->PenilaianLogbook = PenilaianLogbook::where('indikator_kinerja_id',  $this->_Request->input('indikator_kinerja_id'))
        ->where('tanggal',  $this->_Request->input('tanggal'))
        ->where('penilaian_prestasi_kerja_id',  $this->_Request->input('penilaian_prestasi_kerja_id'))
        ->first();

        if (!$this->Model->PenilaianLogbook) {
          $this->Model->PenilaianLogbook = new PenilaianLogbook();
          $this->Model->PenilaianLogbook->indikator_kinerja_id = $this->_Request->input('indikator_kinerja_id');
          $this->Model->PenilaianLogbook->tanggal = $this->_Request->input('tanggal');
          $this->Model->PenilaianLogbook->penilaian_prestasi_kerja_id = $this->_Request->input('penilaian_prestasi_kerja_id');
        }

        if ($this->Model->PenilaianLogbook) {
          $this->Model->PenilaianLogbook->nilai = $this->_Request->input('nilai');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->PenilaianLogbook) {
            $this->Json::set('exception.key', 'NotFoundPenilaianLogbook');
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
