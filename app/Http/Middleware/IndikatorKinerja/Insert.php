<?php

namespace App\Http\Middleware\IndikatorKinerja;

use App\Models\IndikatorKinerja;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->IndikatorKinerja = new IndikatorKinerja();

        $this->Model->IndikatorKinerja->name = $this->_Request->input('name');
        if($this->_Request->input('parent_id')) $this->Model->IndikatorKinerja->parent_id = $this->_Request->input('parent_id');
        $this->Model->IndikatorKinerja->unit_kerja_id = $this->_Request->input('unit_kerja_id');
        $this->Model->IndikatorKinerja->perspektif_id = $this->_Request->input('perspektif_id');
        $this->Model->IndikatorKinerja->tipe_indikator = 'iku';
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
