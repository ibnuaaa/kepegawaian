<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataAnggaran extends Model
{
    use SoftDeletes;
    protected $table = 'mata_anggaran';


    public static function child($eselon_id)
    {

        return static::with(implode('.', array_fill(0, 100, 'children')))
                    ->where('parent_id', $eselon_id)
                    ->get();
    }

    public function children()
    {
        return $this->hasMany(MataAnggaran::class, 'parent_id', 'id')
                ->with('unit_kerja')
                ;
    }

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))
                    ->where('parent_id', '=', NULL)
                    ->get();
    }

    public function parent()
    {
        return $this->hasOne(MataAnggaran::class, 'id', 'mata_anggaran.parent_id');
    }

    public function parents()
    {
        return $this->hasOne(MataAnggaran::class, 'id', 'parent_id')
            ->with('parents');
    }

    public function unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'unit_kerja_id');
    }

    public function unit_kerja_with_parents()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'mata_anggaran.unit_kerja_id')->with('parents');
    }

    public function mata_anggaran_child()
    {
        return $this->hasMany(MataAnggaran::class, 'parent_id', 'id')->with('kegiatan');
    }

    public function kegiatan()
    {
        return $this->hasMany(IndikatorSkp::class, 'parent_id', 'id');
    }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'mata_anggaran_id', 'id');
    // }

    // public function user_without_mata_anggaran()
    // {
    //     return $this->hasOne(User::class, 'mata_anggaran_id', 'id');
    // }
}
