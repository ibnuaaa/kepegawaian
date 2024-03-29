<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJabatanFungsional extends Model
{
    use SoftDeletes;
    protected $table = 'user_jabatan_fungsional';

    public function jabatan_fungsional()
    {
        return $this->hasOne(JabatanFungsional::class, 'id', 'jabatan_fungsional_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
