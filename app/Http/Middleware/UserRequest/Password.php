<?php

namespace App\Http\Middleware\UserRequest;

use App\Models\UserRequest;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Password extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserRequest = UserRequest::find($this->_Request->input('id'));
        if ($this->Model->UserRequest) {
            $this->Model->UserRequest->password = $this->_Request->input('password');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'id' => 'required',
            'password' => 'required|min:6|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);
        if (!$this->Model->UserRequest) {
            $this->Json::set('exception.code', 'NotFoundUserRequest');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
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
