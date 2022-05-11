<?php

namespace App\Http\Middleware\Complaint;

use App\Models\Complaint;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Complaint = new Complaint();

        $this->Model->Complaint->status = 1;
        $this->Model->Complaint->from_user_id = Auth::user()['id'];
        $this->Model->Complaint->from_unit_kerja_id = Auth::user()['unit_kerja_id'];
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            // 'name' => 'required'
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
