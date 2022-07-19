<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class EKinerjaIki extends Model
{
    use SoftDeletes;
    protected $table = 'e_kinerja_iki';

    public function e_kinerja_iki_detail() {
        return $this->hasmany(EKinerjaIkiDetail::class, 'e_kinerja_iki_id', 'id');
    }
}
