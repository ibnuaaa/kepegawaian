<?php

namespace App\Http\Middleware\PenilaianPrestasiKerjaItem;

use App\Models\PenilaianPrestasiKerjaItem;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->PenilaianPrestasiKerjaItem = new PenilaianPrestasiKerjaItem();
        $this->Model->PenilaianPrestasiKerjaItem->penilaian_prestasi_kerja_id = $this->_Request->input('penilaian_prestasi_kerja_id');
        $this->Model->PenilaianPrestasiKerjaItem->indikator_kinerja_id = $this->_Request->input('indikator_kinerja_id');
        $this->Model->PenilaianPrestasiKerjaItem->user_id = MyAccount()->id;
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
          'penilaian_prestasi_kerja_id' => 'required'
        ]);

        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where('penilaian_prestasi_kerja_id', $this->_Request->input('penilaian_prestasi_kerja_id'))->
            where('indikator_kinerja_id',  $this->_Request->input('indikator_kinerja_id'))->first();

        if (!empty($PenilaianPrestasiKerjaItem)) {
            $this->Json::set('exception.key', 'DuplicatePenilaianPrestasiKerjaItem');
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
