<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorTetapDasarNilai extends Model
{
    use SoftDeletes;
    protected $table = 'indikator_tetap_dasar_nilai';

}
