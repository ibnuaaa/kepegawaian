<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;
    protected $table = 'complaint';

    public function from_user()
    {
        return $this->hasOne(User::class, 'id', 'complaint.from_user_id')->with('foto_profile_single');
    }

    public function from_unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'complaint.from_unit_kerja_id');
    }

    public function complaint_to()
    {
        return $this->hasMany(ComplaintTo::class, 'complaint_id', 'complaint.id')->with('destination_unit_kerja');
    }

    public function complaint_reply()
    {
        return $this->hasMany(ComplaintReply::class, 'complaint_id', 'complaint.id')->with('user');
    }

    public function complaint_user_resolve()
    {
        return $this->hasMany(ComplaintUserResolve::class, 'complaint_id', 'complaint.id')->with('user');
    }

    public function foto_complaint()
    {
        return $this->hasMany(Document::class, 'object_id', 'complaint.id')
                    ->where('object', 'foto_complaint')
                    ->with('storage');
    }

}
