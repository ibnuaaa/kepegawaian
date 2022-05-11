<?php

namespace App\Http\Middleware\Complaint;

use App\Models\Complaint;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->Complaint = Complaint::where('id', $this->Id)->first();
        if ($this->Model->Complaint) {
            if(!empty($this->_Request->input('title'))) $this->Model->Complaint->title = $this->_Request->input('title');
            if(!empty($this->_Request->input('description'))) $this->Model->Complaint->description = $this->_Request->input('description');
            if(!empty($this->_Request->input('urgency_type'))) $this->Model->Complaint->urgency_type = $this->_Request->input('urgency_type');
            if(!empty($this->_Request->input('status'))) $this->Model->Complaint->status = $this->_Request->input('status');
        }
    }

    private function Validation()
    {
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
