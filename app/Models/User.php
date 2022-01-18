<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'username', 'email', 'phone_number', 'password', 'name',
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = ['updated_at', 'created_at', 'deleted_at'];

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id')->with('parents');
    }

    public function user_pendidikan()
    {
        return $this->hasMany(UserPendidikan::class, 'user_id', 'user.id')->with('pendidikan');
    }

    public function user_pelatihan()
    {
        return $this->hasMany(UserPelatihan::class, 'user_id', 'user.id');
    }

    public function user_keluarga()
    {
        return $this->hasMany(UserKeluarga::class, 'user_id', 'user.id');
    }

    public function user_jabatan()
    {
        return $this->hasMany(UserJabatan::class, 'user_id', 'user.id')->with('unit_kerja')->with('position');
    }

    public function user_golongan()
    {
        return $this->hasMany(UserGolongan::class, 'user_id', 'user.id')->with('golongan');
    }

}
