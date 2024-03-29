<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use SoftDeletes;
    protected $table = 'jabatan';

    public static function child($eselon_id)
    {

        return static::with(implode('.', array_fill(0, 100, 'children')))
                    ->where('parent_id', $eselon_id)
                    ->get();
    }

    public function children()
    {
        return $this->hasMany(Jabatan::class, 'parent_id', 'id')
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
        return $this->hasOne(Jabatan::class, 'id', 'user.parent_id')
            ->with('user');
    }

    public function parents()
    {
        return $this->hasOne(Jabatan::class, 'id', 'parent_id')
            ->with('parents');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'jabatan_id', 'id')->with('jabatan');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'jabatan_id', 'id');
    }

    public function user_without_jabatan()
    {
        return $this->hasOne(User::class, 'jabatan_id', 'id');
    }


}
