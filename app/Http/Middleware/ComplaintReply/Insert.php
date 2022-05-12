<?php

namespace App\Http\Middleware\ComplaintReply;

use App\Models\ComplaintReply;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->ComplaintReply = new ComplaintReply();


        // echo date_default_timezone_get();
        // echo date('Y-m-d H:i:s');
        // die();

        $this->Model->ComplaintReply->complaint_id = $this->_Request->input('complaint_id');
        $this->Model->ComplaintReply->user_id = MyAccount()->id;
        $this->Model->ComplaintReply->message = $this->_Request->input('message');

    }

    private function Validation()
    {
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
