<?php

namespace App\Http\Middleware\IndikatorSkp;

use App\Models\IndikatorSkp;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->IndikatorSkp = new IndikatorSkp();

        $this->Model->IndikatorSkp->name = $this->_Request->input('name');
        $this->Model->IndikatorSkp->parent_id = $this->_Request->input('parent_id');
        $this->Model->IndikatorSkp->created_user_id = MyAccount()->id;
        $this->Model->IndikatorSkp->created_jabatan_id = MyAccount()->jabatan_id;
        $this->Model->IndikatorSkp->tipe_indikator = 'iki';
        $this->Model->IndikatorSkp->unit_kerja_id = MyAccount()->unit_kerja_id;
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
