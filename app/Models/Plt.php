<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plt extends Model
{
    use SoftDeletes;
    protected $table = 'user_plt';

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id');
    }
}
