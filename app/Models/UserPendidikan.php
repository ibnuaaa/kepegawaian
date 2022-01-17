<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPendidikan extends Model
{
    use SoftDeletes;
    protected $table = 'user_pendidikan';

    public function pendidikan()
    {
        return $this->hasOne(Pendidikan::class, 'id', 'pendidikan_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
