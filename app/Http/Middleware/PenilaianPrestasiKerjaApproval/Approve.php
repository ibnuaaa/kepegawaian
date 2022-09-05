<?php

namespace App\Http\Middleware\PenilaianPrestasiKerjaApproval;

use App\Models\PenilaianPrestasiKerjaApproval;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class Approve extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApproval::where('user_id', Auth::user()->id)
            ->where('penilaian_prestasi_kerja_id', $this->_Request->input('penilaian_prestasi_kerja_id'))
            ->first();

        if (empty($this->Model->PenilaianPrestasiKerjaApproval)) {
            $this->Model->PenilaianPrestasiKerjaApproval = new PenilaianPrestasiKerjaApproval();
            $this->Model->PenilaianPrestasiKerjaApproval->user_id = Auth::user()->id;
            $this->Model->PenilaianPrestasiKerjaApproval->penilaian_prestasi_kerja_id = $this->_Request->input('penilaian_prestasi_kerja_id');
        }
        $this->Model->PenilaianPrestasiKerjaApproval->approved_at = date('Y-m-d H:i:s');
        $this->Model->PenilaianPrestasiKerjaApproval->status = '2';
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
