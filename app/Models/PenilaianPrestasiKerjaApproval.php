<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianPrestasiKerjaApproval extends Model
{
    use SoftDeletes;
    protected $table = 'penilaian_prestasi_kerja_approval';

    public function penilaian_prestasi_kerja()
    {
        return $this->hasOne(PenilaianPrestasiKerja::class, 'id', 'penilaian_prestasi_kerja_id')
          ->with('user')
          ->with('penilaian_prestasi_kerja_item')
          ->with('penilaian_prestasi_kerja_approval')
          ->with('penilaian_prestasi_kerja_my_approval')
          ->with('foto_penilaian_prestasi_kerja')
          ->with('penilaian_kualitas')
          ;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
