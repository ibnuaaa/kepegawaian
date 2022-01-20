<?php

namespace App\Http\Middleware\UnitKerja;

use App\Models\UnitKerja;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->UnitKerja = UnitKerja::find($this->Id);

        if ($this->Model->UnitKerja) {
            $this->Model->UnitKerja->name = $this->_Request->input('name');

            if($this->_Request->input('parent_id')) $this->Model->UnitKerja->parent_id = $this->_Request->input('parent_id');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if (!$this->Model->UnitKerja) {
            $this->Json::set('exception.code', 'NotFoundUnitKerja');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
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
