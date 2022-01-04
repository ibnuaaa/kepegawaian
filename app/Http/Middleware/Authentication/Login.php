<?php

namespace App\Http\Middleware\Authentication;

use App\Models\User;
use App\Models\UsersFromApi;
use App\Models\PositionsFromApi;
use App\Models\Position;
use App\Models\ApiLog;

use Closure;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Login extends BaseMiddleware
{
    private function Initiate()
    {
        $this->username = $this->_Request->input('username');
        $this->password = $this->_Request->input('password');
        $this->isWithEmail = filter_var($this->username, FILTER_VALIDATE_EMAIL);
    }

    private function Validation()
    {
        if (!$this->isWithEmail) {
            $validator = Validator::make($this->_Request->all(), [
                'username' => 'required|max:255',
                'password' => 'required|max:255'
            ]);
        } else {
            $validator = Validator::make($this->_Request->all(), [
                'username' => 'required|email|max:255',
                'password' => 'required|max:255'
            ]);
        }

        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }

        if (($this->isWithEmail) && !$this->Model->User = User::where('email', $this->username)->first()) {
            $this->Json::set('errors.username', [
                trans('validation.login.invalid_email')
            ]);
            return false;
        } elseif ((!$this->isWithEmail) && !$this->Model->User = User::where('username', $this->username)->first()) {
            $this->Json::set('errors.username', [
                trans('validation.login.username')
            ]);
            return false;
        } elseif (!Hash::check($this->password, $this->Model->User->password)) {
            $this->Json::set('errors.password', [
                trans('validation.login.invalid_password')
            ]);
            return false;
        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
