<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorSkp extends Model
{
    use SoftDeletes;
    protected $table = 'indikator_kinerja';

    // public function indikator_skp_child()
    // {
    //     return $this->hasMany(IndikatorSkp::class, 'parent_id', 'id')->with('kegiatan');
    // }
    //
    // public function kegiatan()
    // {
    //     return $this->hasMany(IndikatorSkp::class, 'parent_id', 'id');
    // }

}
