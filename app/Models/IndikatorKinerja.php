<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorKinerja extends Model
{
    use SoftDeletes;
    protected $table = 'indikator_kinerja';


    public static function child($eselon_id)
    {

        return static::with(implode('.', array_fill(0, 100, 'children')))
                    ->where('parent_id', $eselon_id)
                    ->get();
    }

    public function children()
    {
        return $this->hasMany(IndikatorKinerja::class, 'parent_id', 'id')
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
        return $this->hasOne(IndikatorKinerja::class, 'id', 'indikator_kinerja.parent_id');
    }

    public function parents()
    {
        return $this->hasOne(IndikatorKinerja::class, 'id', 'parent_id')
            ->with('parents');
    }

    public function unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'unit_kerja_id');
    }

    public function unit_kerja_with_parents()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'indikator_kinerja.unit_kerja_id')->with('parents');
    }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'indikator_kinerja_id', 'id');
    // }

    // public function user_without_indikator_kinerja()
    // {
    //     return $this->hasOne(User::class, 'indikator_kinerja_id', 'id');
    // }
}
