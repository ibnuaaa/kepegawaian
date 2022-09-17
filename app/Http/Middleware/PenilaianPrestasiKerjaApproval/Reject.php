<?php

namespace App\Http\Middleware\PenilaianPrestasiKerjaApproval;

use App\Models\PenilaianPrestasiKerjaApproval;
use App\Models\PenilaianPrestasiKerjaReject;


use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class Reject extends BaseMiddleware
{
    private function Initiate()
    {


        // UPDATE DULU SEMUA JADI RECEIVE REJECT
        PenilaianPrestasiKerjaApproval::where(
          'penilaian_prestasi_kerja_id', $this->_Request->input('penilaian_prestasi_kerja_id')
        )->where('status', '2')->update([
          'status' => '4'
        ]);

        $this->Model->PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApproval::where('user_id', Auth::user()->id)
            ->where('penilaian_prestasi_kerja_id', $this->_Request->input('penilaian_prestasi_kerja_id'))
            ->first();

        if (empty($this->Model->PenilaianPrestasiKerjaApproval)) {
            $this->Model->PenilaianPrestasiKerjaApproval = new PenilaianPrestasiKerjaApproval();
            $this->Model->PenilaianPrestasiKerjaApproval->user_id = Auth::user()->id;
            $this->Model->PenilaianPrestasiKerjaApproval->penilaian_prestasi_kerja_id = $this->_Request->input('penilaian_prestasi_kerja_id');
        }

        $this->Model->PenilaianPrestasiKerjaReject = new PenilaianPrestasiKerjaReject();
        $this->Model->PenilaianPrestasiKerjaReject->notes = $this->_Request->input('notes');
        $this->Model->PenilaianPrestasiKerjaReject->user_id = Auth::user()->id;
        $this->Model->PenilaianPrestasiKerjaReject->penilaian_prestasi_kerja_id = $this->_Request->input('penilaian_prestasi_kerja_id');

        // 3. reject, 4. receive_reject, 5. approve_reject
        $this->Model->PenilaianPrestasiKerjaApproval->status = '3';
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
