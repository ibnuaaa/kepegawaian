<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPendidikanRequest extends Model
{
    use SoftDeletes;
    protected $table = 'user_pendidikan_request';

    public function pendidikan()
    {
        return $this->hasOne(Pendidikan::class, 'id', 'pendidikan_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function user_pendidikan()
    {
        return $this->hasOne(UserPendidikan::class, 'id', 'user_pendidikan_id');
    }

    public function foto_ijazah()
    {
        return $this->hasMany(Document::class, 'object_id', 'id')
                    ->where('object', 'foto_ijazah_request')
                    ->with('storage');
    }

    public function foto_transkrip_nilai()
    {
        return $this->hasMany(Document::class, 'object_id', 'id')
                    ->where('object', 'foto_transkrip_nilai_request')
                    ->with('storage');
    }
}
