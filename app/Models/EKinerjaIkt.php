<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class EKinerjaIkt extends Model
{
    use SoftDeletes;
    protected $table = 'e_kinerja_ikt';

    public function e_kinerja_ikt_detail() {
        return $this->hasmany(EKinerjaIktDetail::class, 'e_kinerja_ikt_id', 'id');
    }
}
