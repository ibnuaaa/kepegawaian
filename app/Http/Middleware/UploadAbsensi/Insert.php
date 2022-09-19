<?php

namespace App\Http\Middleware\UploadAbsensi;

use App\Models\UploadAbsensi;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->UploadAbsensi = new UploadAbsensi();
        $this->Model->UploadAbsensi->month = $this->_Request->input('month');
        $this->Model->UploadAbsensi->year = $this->_Request->input('year');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'month' => 'required',
            'year' => 'required'
        ]);
        $isExist = UploadAbsensi::where('month', $this->Model->UploadAbsensi->month)->where('year', $this->Model->UploadAbsensi->year)->first();
        if ($isExist) {
            $this->Json::set('exception.code', 'MonthYearExist');
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
