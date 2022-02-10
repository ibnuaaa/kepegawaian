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

class Approve extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserRequest = UserRequest::where('id', $this->_Request->input('id'))->first();
        if ($this->Model->UserRequest) {
            if($this->_Request->input('status_sdm_approved')) $this->Model->UserRequest->status_sdm = 'approved';
            if($this->_Request->input('status_diklat_approved')) $this->Model->UserRequest->status_diklat = 'approved';
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
