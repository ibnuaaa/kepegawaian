<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRequest extends Model
{
    use SoftDeletes;
    protected $table = 'user_request';

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id')->with('parents');
    }

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id')->with('parents');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_request.user_id');
    }

    public function jabatan_fungsional()
    {
        return $this->hasOne(JabatanFungsional::class, 'id', 'user_request.jabatan_fungsional_id');
    }

    public function golongan()
    {
        return $this->hasOne(Golongan::class, 'id', 'user_request.golongan_id');
    }

    public function user_pendidikan()
    {
        return $this->hasMany(UserPendidikanRequest::class, 'user_request_id', 'user_request.id')->with('pendidikan')->withTrashed()->with('user_pendidikan');
    }

    public function user_pelatihan()
    {
        return $this->hasMany(UserPelatihanRequest::class, 'user_request_id', 'user_request.id')->withTrashed()->with('user_pelatihan');
    }

    public function user_keluarga()
    {
        return $this->hasMany(UserKeluargaRequest::class, 'user_request_id', 'user_request.id')->withTrashed()->with('user_keluarga');
    }

    public function user_jabatan()
    {
        return $this->hasMany(UserJabatanRequest::class, 'user_request_id', 'user_request.id')->with('unit_kerja')->with('jabatan')->withTrashed()->with('user_jabatan');
    }

    public function user_jabatan_fungsional()
    {
        return $this->hasMany(UserJabatanFungsionalRequest::class, 'user_request_id', 'user_request.id')->with('jabatan_fungsional')->withTrashed()->with('user_jabatan_fungsional');
    }

    public function user_golongan()
    {
        return $this->hasMany(UserGolonganRequest::class, 'user_request_id', 'user_request.id')->with('golongan')->withTrashed()->with('user_golongan');
    }

    public function unit_kerja()
    {
        return $this->hasOne(UnitKerjaRequest::class, 'id', 'unit_kerja_id')->with('parents');
    }


    public function foto_ktp()
    {
        return $this->hasMany(Document::class, 'object_id', 'user_request.id')
                    ->where('object', 'foto_ktp_request')
                    ->with('storage');
    }

    public function foto_npwp()
    {
        return $this->hasMany(Document::class, 'object_id', 'user_request.id')
                    ->where('object', 'foto_npwp_request')
                    ->with('storage');
    }

    public function foto_kk()
    {
        return $this->hasMany(Document::class, 'object_id', 'user_request.id')
                    ->where('object', 'foto_kk_request')
                    ->with('storage');
    }

    public function foto_akta_nikah()
    {
        return $this->hasMany(Document::class, 'object_id', 'user_request.id')
                    ->where('object', 'foto_akta_nikah_request')
                    ->with('storage');
    }

    public function foto_bpjs()
    {
        return $this->hasMany(Document::class, 'object_id', 'user_request.id')
                    ->where('object', 'foto_bpjs_request')
                    ->with('storage');
    }

    public function foto_profile()
    {
        return $this->hasMany(Document::class, 'object_id', 'user_request.id')
                    ->where('object', 'foto_profile_request')
                    ->with('storage');
    }

    public function foto_sip()
    {
        return $this->hasMany(Document::class, 'object_id', 'user_request.id')
                    ->where('object', 'foto_sip_request')
                    ->with('storage');
    }

}
