<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorTetap extends Model
{
    use SoftDeletes;
    protected $table = 'indikator_tetap';

    public function indikator_tetap_dasar_nilai()
    {
        return $this->hasMany(IndikatorTetapDasarNilai::class, 'indikator_tetap_id', 'id');
    }

}
