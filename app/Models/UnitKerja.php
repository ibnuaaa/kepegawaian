<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use SoftDeletes;
    protected $table = 'unit_kerja';


    public static function child($eselon_id)
    {

        return static::with(implode('.', array_fill(0, 100, 'children')))
                    ->where('parent_id', $eselon_id)
                    ->get();
    }

    public function children()
    {
        return $this->hasMany(UnitKerja::class, 'parent_id', 'id')
                ->with('users');
    }

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))
                    ->where('parent_id', '=', NULL)
                    ->get();
    }

    public function parent()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'user.parent_id')
            ->with('user');
    }

    public function parents()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'parent_id')
            ->with('parents');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'unit_kerja_id', 'id')->with('unit_kerja');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'unit_kerja_id', 'id');
    }

    public function user_without_unit_kerja()
    {
        return $this->hasOne(User::class, 'unit_kerja_id', 'id');
    }
}
