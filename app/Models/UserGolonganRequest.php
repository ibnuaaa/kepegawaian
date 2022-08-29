<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGolonganRequest extends Model
{
    use SoftDeletes;
    protected $table = 'user_golongan_request';

    public function golongan()
    {
        return $this->hasOne(Golongan::class, 'id', 'golongan_id');
    }

    public function user_golongan()
    {
        return $this->hasOne(UserGolongan::class, 'id', 'user_golongan_id');
    }

    public function foto_perjanjian_kerja()
    {
        return $this->hasMany(Document::class, 'object_id', 'id')
                    ->where('object', 'foto_perjanjian_kerja_request')
                    ->with('storage');
    }

}
