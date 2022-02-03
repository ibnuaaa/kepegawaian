<?php

namespace App\Http\Middleware\UserRequest\Developer;

use App\Models\UserRequest;
use App\Models\Project;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Token extends BaseMiddleware
{
    private function Initiate($request)
    {
        if ($this->Id === 'my'); {
            $this->Id = $this->_Request->user()->id;
        }
        $this->Model->UserRequest = UserRequest::find($this->Id);
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
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
        if (!isset($this->Model->UserRequest->position)) {
            $this->Json::set('exception.code', 'UnknownPosition');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }
        if ($this->Model->UserRequest->position->name !== 'developer') {
            $this->Json::set('exception.code', 'NotDeveloperAccount');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
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
