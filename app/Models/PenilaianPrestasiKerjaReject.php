<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianPrestasiKerjaReject extends Model
{
    use SoftDeletes;
    protected $table = 'penilaian_prestasi_kerja_reject';

    public function penilaian_prestasi_kerja()
    {
        return $this->hasOne(PenilaianPrestasiKerja::class, 'id', 'penilaian_prestasi_kerja_id')
          ->with('user')
          ;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->with('jabatan')->with('golongan')->with('jabatan_fungsional');
    }
}
