<?php

namespace App\Http\Middleware\ComplaintReply;

use App\Models\ComplaintReply;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->ComplaintReply = ComplaintReply::where('id', $this->Id)->first();
        if ($this->Model->ComplaintReply) {
          $this->Model->ComplaintReply->delegate_by_user_id = MyAccount()->id;
          $this->Model->ComplaintReply->delegate_unit_kerja_id = MyAccount()->unit_kerja_id;
          $this->Model->ComplaintReply->destination_unit_kerja_id = $this->_Request->input('destination_unit_kerja_id');
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
