<?php

namespace App\Http\Middleware\PenilaianPrestasiKerjaApproval;

use App\Models\PenilaianPrestasiKerjaApproval;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Delete extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApproval::find($this->Id);
    }

    private function Validation()
    {
        $validator = Validator::make([ 'id' => $this->Id ], $this->Rules);
        if (!$this->Model->PenilaianPrestasiKerjaApproval) {
            $this->Json::set('exception.code', 'NotFoundPenilaianPrestasiKerjaApproval');
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
