<?php

namespace App\Http\Middleware\ComplaintTo;

use App\Models\ComplaintTo;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->ComplaintTo = new ComplaintTo();

        $this->Model->ComplaintTo->complaint_id = $this->_Request->input('complaint_id');
        $this->Model->ComplaintTo->delegate_by_user_id = MyAccount()->id;
        $this->Model->ComplaintTo->delegate_unit_kerja_id = MyAccount()->unit_kerja_id;
        $this->Model->ComplaintTo->destination_unit_kerja_id = $this->_Request->input('destination_unit_kerja_id');



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
