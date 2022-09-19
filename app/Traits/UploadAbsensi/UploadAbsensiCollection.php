<?php

namespace App\Traits\UploadAbsensi;

/* Models */
use App\Models\UploadAbsensi;

use DB;

trait UploadAbsensiCollection
{
    public function __construct()
    {
        $this->UploadAbsensiModel = UploadAbsensi::class;
        $this->UploadAbsensiTable = getTable($this->UploadAbsensiModel);
    }

    public function GetUploadAbsensiDetails($UploadAbsensis)
    {
        $UploadAbsensiID = $UploadAbsensis->pluck('id');

        $UploadAbsensis->map(function($UploadAbsensi) {
            return $UploadAbsensi;
        });
        return $UploadAbsensis;
    }

}
