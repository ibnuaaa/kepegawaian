<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianPrestasiKerjaItem extends Model
{
    use SoftDeletes;
    protected $table = 'penilaian_prestasi_kerja_item';


    public function indikator_kinerja()
    {
        return $this->hasOne(IndikatorKinerja::class, 'id', 'indikator_kinerja_id');
    }

}