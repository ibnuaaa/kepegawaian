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
        return $this->hasMany(PenilaianPrestasiKerjaItem::class, 'penilaian_prestasi_kerja_id', 'id')->where('type', 'skp')
        ->with('indikator_kinerja')
        ;
    }

    public function penilaian_perilaku_kerja()
    {
        return $this->hasMany(PenilaianPrestasiKerjaItem::class, 'penilaian_prestasi_kerja_id', 'id')->where('type', 'perilaku_kerja');
    }

    public function penilaian_kualitas()
    {
        return $this->hasMany(PenilaianPrestasiKerjaItem::class, 'penilaian_prestasi_kerja_id', 'id')->where('type', 'kualitas');
    }

    public function penilaian_tambahan()
    {
        return $this->hasMany(PenilaianPrestasiKerjaItem::class, 'penilaian_prestasi_kerja_id', 'id')->where('type', 'tambahan');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id');
    }

    public function jabatan_fungsional()
    {
        return $this->hasOne(JabatanFungsional::class, 'id', 'jabatan_fungsional_id');
    }

    public function unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'unit_kerja_id');
    }

    public function foto_penilaian_prestasi_kerja()
    {
        return $this->hasMany(Document::class, 'object_id', 'id')
                    ->where('object', 'foto_penilaian_prestasi_kerja')
                    ->with('storage');
    }


}
