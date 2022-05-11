<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplaintReply extends Model
{
    use SoftDeletes;
    protected $table = 'complaint_reply';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
