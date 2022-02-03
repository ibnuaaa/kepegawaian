<?php

namespace App\Http\Middleware\UserPelatihanRequest;

use App\Models\UserPelatihanRequest;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->UserPelatihanRequest = new UserPelatihanRequest();
        $this->Model->UserPelatihanRequest->user_id = $this->_Request->input('user_id');
        $this->Model->UserPelatihanRequest->user_request_id = $this->_Request->input('user_request_id');
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
