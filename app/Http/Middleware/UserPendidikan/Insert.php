<?php

namespace App\Http\Middleware\UserPendidikan;

use App\Models\UserPendidikan;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->UserPendidikan = new UserPendidikan();
        $this->Model->UserPendidikan->pendidikan_id = $this->_Request->input('pendidikan_id');
        $this->Model->UserPendidikan->pendidikan_detail = $this->_Request->input('pendidikan_detail');
        $this->Model->UserPendidikan->no_ijazah = $this->_Request->input('no_ijazah');
        $this->Model->UserPendidikan->tahun_lulus = $this->_Request->input('tahun_lulus');
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
