<?php

namespace App\Http\Middleware\PenilaianPerilakuKerja;

use App\Models\PenilaianPerilakuKerja;
use App\Models\PerilakuKerja;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->PenilaianPerilakuKerja = new PenilaianPerilakuKerja();

        $this->Model->PenilaianPerilakuKerja->user_id = MyAccount()->id;

        
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
