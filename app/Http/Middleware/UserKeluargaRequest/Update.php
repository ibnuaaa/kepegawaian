<?php

namespace App\Http\Middleware\UserKeluargaRequest;

use App\Models\UserKeluargaRequest;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->UserKeluargaRequest = UserKeluargaRequest::where('id', $this->Id)->first();
        if ($this->Model->UserKeluargaRequest) {
          if ($this->_Request->input('nama_lengkap')) $this->Model->UserKeluargaRequest->nama_lengkap = $this->_Request->input('nama_lengkap');
          if ($this->_Request->input('nik')) $this->Model->UserKeluargaRequest->nik = $this->_Request->input('nik');
          if ($this->_Request->input('jenis_kelamin')) $this->Model->UserKeluargaRequest->jenis_kelamin = $this->_Request->input('jenis_kelamin');
          if ($this->_Request->input('tempat_lahir')) $this->Model->UserKeluargaRequest->tempat_lahir = $this->_Request->input('tempat_lahir');
          if ($this->_Request->input('tanggal_lahir')) $this->Model->UserKeluargaRequest->tanggal_lahir = $this->_Request->input('tanggal_lahir');
          if ($this->_Request->input('agama_id')) $this->Model->UserKeluargaRequest->agama_id = $this->_Request->input('agama_id');
          if ($this->_Request->input('pendidikan_id')) $this->Model->UserKeluargaRequest->pendidikan_id = $this->_Request->input('pendidikan_id');
          if ($this->_Request->input('jenis_pekerjaan')) $this->Model->UserKeluargaRequest->jenis_pekerjaan = $this->_Request->input('jenis_pekerjaan');
          if ($this->_Request->input('status_perkawinan')) $this->Model->UserKeluargaRequest->status_perkawinan = $this->_Request->input('status_perkawinan');
          if ($this->_Request->input('hubungan_keluarga')) $this->Model->UserKeluargaRequest->hubungan_keluarga = $this->_Request->input('hubungan_keluarga');
          if ($this->_Request->input('kewarganegaraan')) $this->Model->UserKeluargaRequest->kewarganegaraan = $this->_Request->input('kewarganegaraan');
          if ($this->_Request->input('no_paspor')) $this->Model->UserKeluargaRequest->no_paspor = $this->_Request->input('no_paspor');
          if ($this->_Request->input('no_kitas')) $this->Model->UserKeluargaRequest->no_kitas = $this->_Request->input('no_kitas');
          if ($this->_Request->input('ayah')) $this->Model->UserKeluargaRequest->ayah = $this->_Request->input('ayah');
          if ($this->_Request->input('ibu')) $this->Model->UserKeluargaRequest->ibu = $this->_Request->input('ibu');

          if ($this->_Request->input('hub_keluarga_id')) $this->Model->UserKeluargaRequest->hub_keluarga_id = $this->_Request->input('hub_keluarga_id');
          if ($this->_Request->input('nip')) $this->Model->UserKeluargaRequest->nip = $this->_Request->input('nip');
          if ($this->_Request->input('no_akta_nikah')) $this->Model->UserKeluargaRequest->no_akta_nikah = $this->_Request->input('no_akta_nikah');
          if ($this->_Request->input('tgl_pernikahan')) $this->Model->UserKeluargaRequest->tgl_pernikahan = $this->_Request->input('tgl_pernikahan');
          if ($this->_Request->input('alamat')) $this->Model->UserKeluargaRequest->alamat = $this->_Request->input('alamat');
          if ($this->_Request->input('hp')) $this->Model->UserKeluargaRequest->hp = $this->_Request->input('hp');
          if ($this->_Request->input('status_pasangan')) $this->Model->UserKeluargaRequest->status_pasangan = $this->_Request->input('status_pasangan');
          if ($this->_Request->input('no_akta_cerai_meninggal')) $this->Model->UserKeluargaRequest->no_akta_cerai_meninggal = $this->_Request->input('no_akta_cerai_meninggal');
          if ($this->_Request->input('tgl_akta_cerai_meninggal')) $this->Model->UserKeluargaRequest->tgl_akta_cerai_meninggal = $this->_Request->input('tgl_akta_cerai_meninggal');
          if ($this->_Request->input('akta_kelahiran')) $this->Model->UserKeluargaRequest->akta_kelahiran = $this->_Request->input('akta_kelahiran');
          if ($this->_Request->input('status_pekerjaan_id')) $this->Model->UserKeluargaRequest->status_pekerjaan_id = $this->_Request->input('status_pekerjaan_id');
          if ($this->_Request->input('status_anak_id')) $this->Model->UserKeluargaRequest->status_anak_id = $this->_Request->input('status_anak_id');

        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
        ]);
        if (!$this->Model->UserKeluargaRequest) {
            $this->Json::set('exception.key', 'NotFoundUserKeluargaRequest');
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
