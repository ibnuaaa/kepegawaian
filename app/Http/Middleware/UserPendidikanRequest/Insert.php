<?php

namespace App\Http\Middleware\UserPendidikanRequest;

use App\Models\UserPendidikanRequest;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {

        $this->Model->UserPendidikanRequest = new UserPendidikanRequest();
        $this->Model->UserPendidikanRequest->user_request_id = $this->_Request->input('user_request_id');
        $this->Model->UserPendidikanRequest->user_id = $this->_Request->input('user_id');
        $this->Model->UserPendidikanRequest->pendidikan_id = $this->_Request->input('pendidikan_id');
        $this->Model->UserPendidikanRequest->pendidikan_detail = $this->_Request->input('pendidikan_detail');
        $this->Model->UserPendidikanRequest->no_ijazah = $this->_Request->input('no_ijazah');
        $this->Model->UserPendidikanRequest->tahun_lulus = $this->_Request->input('tahun_lulus');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'user_id' => 'required'
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
