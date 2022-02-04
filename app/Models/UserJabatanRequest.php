<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJabatanRequest extends Model
{
    use SoftDeletes;
    protected $table = 'user_jabatan_request';

    public function unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'unit_kerja_id');
    }

    public function user_jabatan()
    {
        return $this->hasOne(UserJabatan::class, 'id', 'user_jabatan_id');
    }

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id');
    }
}
