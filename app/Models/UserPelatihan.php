<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPelatihan extends Model
{
    use SoftDeletes;
    protected $table = 'user_pelatihan';

    public function foto_sertifikat()
    {
        return $this->hasMany(Document::class, 'object_id', 'id')
                    ->where('object', 'foto_sertifikat')
                    ->with('storage');
    }
}
