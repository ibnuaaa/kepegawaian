<?php

namespace App\Http\Middleware\UserRequest;

use App\Models\UserRequest;
use App\Models\Position;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->UserRequest = new UserRequest();

        $this->Model->UserRequest->name = $this->_Request->input('name');
        $this->Model->UserRequest->username = $this->_Request->input('username');
        $this->Model->UserRequest->email = $this->_Request->input('email');
        $this->Model->UserRequest->password = $this->_Request->input('password');
        $this->Model->UserRequest->position_id = $this->_Request->input('position_id');
        $this->Model->UserRequest->jabatan_id = $this->_Request->input('jabatan_id');
        $this->Model->UserRequest->jabatan_fungsional_id = $this->_Request->input('jabatan_fungsional_id');
        $this->Model->UserRequest->golongan_id = $this->_Request->input('golongan_id');
        $this->Model->UserRequest->unit_kerja_id = $this->_Request->input('unit_kerja_id');

        $this->Model->UserRequest->gender = $this->_Request->input('gender');
        $this->Model->UserRequest->nip = $this->_Request->input('nip');

        $this->Model->Position = Position::where('id', $this->Model->UserRequest->position_id)->first();
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'username' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'email' => 'max:255',
            'password' => 'required|min:6|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'position_id' => ['required'],
            'gender' => ['required', 'in:male,female'],
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if (!$this->Model->Position) {
            $this->Json::set('exception.code', 'NotFoundPosition');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
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
