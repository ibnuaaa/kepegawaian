<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserComplete extends Model
{
    use SoftDeletes;

    protected $table = 'users';


    protected $dates = ['updated_at', 'created_at', 'deleted_at'];

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id')->with('parents');
    }

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id')->with('parents');
    }

    public function detail_jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id');
    }

    public function jabatan_fungsional()
    {
        return $this->hasOne(JabatanFungsional::class, 'id', 'jabatan_fungsional_id');
    }

    public function detail_jabatan_fungsional()
    {
        return $this->hasOne(JabatanFungsional::class, 'id', 'jabatan_fungsional_id');
    }

    public function golongan()
    {
        return $this->hasOne(Golongan::class, 'id', 'golongan_id');
    }

    public function detail_golongan()
    {
        return $this->hasOne(Golongan::class, 'id', 'golongan_id');
    }

    public function status_pegawai()
    {
        return $this->hasOne(StatusPegawai::class, 'id', 'status_pegawai_id');
    }

    public function user_pendidikan()
    {
        return $this->hasMany(UserPendidikan::class, 'user_id', 'user.id')
          ->with('pendidikan')
          ->with('foto_ijazah')
          ->with('foto_transkrip_nilai');
    }

    public function user_pelatihan()
    {
        return $this->hasMany(UserPelatihan::class, 'user_id', 'user.id');
    }

    public function user_keluarga()
    {
        return $this->hasMany(UserKeluarga::class, 'user_id', 'user.id');
    }

    public function unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'unit_kerja_id')->with('parents');
    }

    public function plt()
    {
        return $this->hasMany(Plt::class, 'user_id', 'user.id')->with('jabatan');
    }

    public function detail_unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'unit_kerja_id');
    }

    public function user_jabatan()
    {
        return $this->hasMany(UserJabatan::class, 'user_id', 'user.id')->with('unit_kerja')->with('jabatan');
    }

    public function user_jabatan_fungsional()
    {
        return $this->hasMany(UserJabatanFungsional::class, 'user_id', 'user.id')->with('jabatan_fungsional');
    }

    public function user_golongan()
    {
        return $this->hasMany(UserGolongan::class, 'user_id', 'user.id')->with('golongan')->with('foto_perjanjian_kerja');
    }

    public function foto_ktp()
    {
        return $this->hasMany(Document::class, 'object_id', 'user.id')
                    ->where('object', 'foto_ktp')
                    ->with('storage');
    }

    public function foto_npwp()
    {
        return $this->hasMany(Document::class, 'object_id', 'user.id')
                    ->where('object', 'foto_npwp')
                    ->with('storage');
    }

    public function foto_kk()
    {
        return $this->hasMany(Document::class, 'object_id', 'user.id')
                    ->where('object', 'foto_kk')
                    ->with('storage');
    }

    public function foto_akta_nikah()
    {
        return $this->hasMany(Document::class, 'object_id', 'user.id')
                    ->where('object', 'foto_akta_nikah')
                    ->with('storage');
    }

    public function foto_bpjs()
    {
        return $this->hasMany(Document::class, 'object_id', 'user.id')
                    ->where('object', 'foto_bpjs')
                    ->with('storage');
    }

    public function foto_profile()
    {
        return $this->hasMany(Document::class, 'object_id', 'user.id')
                    ->where('object', 'foto_profile')
                    ->with('storage');
    }

    public function foto_profile_single()
    {
        return $this->hasOne(Document::class, 'object_id', 'id')
                    ->where('object', 'foto_profile')
                    ->with('storage');
    }

    public function foto_sip()
    {
        return $this->hasMany(Document::class, 'object_id', 'user.id')
                    ->where('object', 'foto_sip')
                    ->with('storage');
    }

}
