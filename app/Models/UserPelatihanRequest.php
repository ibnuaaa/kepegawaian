<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPelatihanRequest extends Model
{
    use SoftDeletes;
    protected $table = 'user_pelatihan_request';

    public function foto_sertifikat()
    {
        return $this->hasMany(Document::class, 'object_id', 'id')
                    ->where('object', 'foto_sertifikat_request')
                    ->with('storage');
    }
}
