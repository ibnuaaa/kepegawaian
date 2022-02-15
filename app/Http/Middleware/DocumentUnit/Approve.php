<?php

namespace App\Http\Middleware\DocumentUnit;

use App\Models\DocumentUnit;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Approve extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->DocumentUnit = DocumentUnit::where('id', $this->_Request->input('document_unit_id'))->first();
        if ($this->Model->DocumentUnit) {
            $this->Model->DocumentUnit->status = 'approved';
            $this->Model->DocumentUnit->approved_at = date('Y-m-d H:i:s');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->DocumentUnit) {
            $this->Json::set('exception.key', 'NotFoundDocumentUnit');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.key')));
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
