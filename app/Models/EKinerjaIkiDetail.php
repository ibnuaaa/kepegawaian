<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class EKinerjaIkiDetail extends Model
{
    use SoftDeletes;
    protected $table = 'e_kinerja_iki_detail';
}
