<?php

namespace App\Http\Middleware\UserRequest;

use App\Models\UserRequest;
use App\Models\Position;
use App\Models\Blast\Category;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class RequestApproval extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserRequest = UserRequest::where('id', $this->_Request->input('id'))->first();

        if ($this->Model->UserRequest) {
          if (in_array($this->Model->UserRequest->status_sdm, ['rejected', 'new', ''])) $this->Model->UserRequest->status_sdm = 'request_approval';
          if (in_array($this->Model->UserRequest->status_diklat, ['rejected', 'new', ''])) $this->Model->UserRequest->status_diklat = 'request_approval';
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
