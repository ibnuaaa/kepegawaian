<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogActivity extends Model
{
    use SoftDeletes;
    protected $table = 'log_activity';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'log_activity.user_id');
    }
}
