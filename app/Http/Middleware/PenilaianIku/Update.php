<?php

namespace App\Http\Middleware\PenilaianIku;

use App\Models\PenilaianIku;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->PenilaianIku = PenilaianIku::where('id', $this->Id)->first();
        if ($this->Model->PenilaianIku) {
          if(!empty($this->_Request->input('target'))) $this->Model->PenilaianIku->target = $this->_Request->input('target');
          if(!empty($this->_Request->input('realisasi'))) $this->Model->PenilaianIku->realisasi = $this->_Request->input('realisasi');
          if(!empty($this->_Request->input('capaian_unit'))) $this->Model->PenilaianIku->capaian_unit = $this->_Request->input('capaian_unit');
          if(!empty($this->_Request->input('iku'))) $this->Model->PenilaianIku->iku = $this->_Request->input('iku');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->PenilaianIku) {
            $this->Json::set('exception.key', 'NotFoundPenilaianIku');
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
