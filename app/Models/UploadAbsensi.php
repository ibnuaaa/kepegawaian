<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadAbsensi extends Model
{
    use SoftDeletes;
    protected $table = 'upload_absensi';

    public function upload_absensi_detail() {
        return $this->hasmany(UploadAbsensiDetail::class, 'upload_absensi_id', 'id');
    }
}
