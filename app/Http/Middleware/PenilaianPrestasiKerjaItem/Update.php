<?php

namespace App\Http\Middleware\PenilaianPrestasiKerjaItem;

use App\Models\PenilaianPrestasiKerjaItem;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('id', $this->Id)->first();
        if ($this->Model->PenilaianPrestasiKerjaItem) {
            if(!empty($this->_Request->input('indikator_kinerja_id'))) $this->Model->PenilaianPrestasiKerjaItem->indikator_kinerja_id = $this->_Request->input('indikator_kinerja_id');
            if(!empty($this->_Request->input('indikator_kinerja_text'))) $this->Model->PenilaianPrestasiKerjaItem->indikator_kinerja_text = $this->_Request->input('indikator_kinerja_text');
            if(!empty($this->_Request->input('bobot'))) $this->Model->PenilaianPrestasiKerjaItem->bobot = $this->_Request->input('bobot');
            if(!empty($this->_Request->input('target'))) $this->Model->PenilaianPrestasiKerjaItem->target = $this->_Request->input('target');
            if(!empty($this->_Request->input('realisasi'))) $this->Model->PenilaianPrestasiKerjaItem->realisasi = $this->_Request->input('realisasi');

            if ($this->Model->PenilaianPrestasiKerjaItem->bobot && $target = $this->Model->PenilaianPrestasiKerjaItem->target && $realisasi = $this->Model->PenilaianPrestasiKerjaItem->realisasi) {

                $bobot = $this->Model->PenilaianPrestasiKerjaItem->bobot;
                $target = $this->Model->PenilaianPrestasiKerjaItem->target;
                $realisasi = $this->Model->PenilaianPrestasiKerjaItem->realisasi;

                $capaian = $realisasi / $target;
                $nilai_kinerja = $capaian * $bobot;

                $this->Model->PenilaianPrestasiKerjaItem->capaian = $capaian;
                $this->Model->PenilaianPrestasiKerjaItem->nilai_kinerja = $nilai_kinerja;
            }

            if(!empty($this->_Request->input('capaian'))) $this->Model->PenilaianPrestasiKerjaItem->capaian = $this->_Request->input('capaian');
            if(!empty($this->_Request->input('nilai_kinerja'))) $this->Model->PenilaianPrestasiKerjaItem->nilai_kinerja = $this->_Request->input('nilai_kinerja');

        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->PenilaianPrestasiKerjaItem) {
            $this->Json::set('exception.key', 'NotFoundPenilaianPrestasiKerjaItem');
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
