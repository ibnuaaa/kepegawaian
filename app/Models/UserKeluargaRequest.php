<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserKeluargaRequest extends Model
{
    use SoftDeletes;
    protected $table = 'user_keluarga_request';


}
