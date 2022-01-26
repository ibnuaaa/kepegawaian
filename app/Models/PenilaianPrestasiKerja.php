<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianPrestasiKerja extends Model
{
    use SoftDeletes;
    protected $table = 'penilaian_prestasi_kerja';

    public function penilaian_prestasi_kerja_item()
    {
        return $this->hasMany(PenilaianPrestasiKerjaItem::class, 'penilaian_prestasi_kerja_id', 'id')->where('type', 'skp');
    }

    public function penilaian_perilaku_kerja()
    {
        return $this->hasMany(PenilaianPrestasiKerjaItem::class, 'penilaian_prestasi_kerja_id', 'id')->where('type', 'perilaku_kerja');
    }

    public function penilaian_tambahan()
    {
        return $this->hasMany(PenilaianPrestasiKerjaItem::class, 'penilaian_prestasi_kerja_id', 'id')->where('type', 'tambahan');
    }


}
