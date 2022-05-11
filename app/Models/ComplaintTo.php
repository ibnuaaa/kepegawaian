<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplaintTo extends Model
{
    use SoftDeletes;
    protected $table = 'complaint_to';

    public function destination_unit_kerja()
    {
        return $this->hasOne(UnitKerja::class, 'id', 'destination_unit_kerja_id');
    }
}
