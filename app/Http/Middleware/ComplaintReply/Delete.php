<?php

namespace App\Http\Middleware\ComplaintReply;

use App\Models\ComplaintReply;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Delete extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->ComplaintReply = ComplaintReply::find($this->Id);
    }

    private function Validation()
    {
        $validator = Validator::make([ 'id' => $this->Id ], $this->Rules);
        if (!$this->Model->ComplaintReply) {
            $this->Json::set('exception.code', 'NotFoundComplaintReply');
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
