<?php

namespace App\Traits\MataAnggaran;

/* Models */
use App\Models\MataAnggaran;

use DB;

trait MataAnggaranCollection
{
    public function __construct()
    {
        $this->MataAnggaranModel = MataAnggaran::class;
        $this->MataAnggaranTable = getTable($this->MataAnggaranModel);
    }

    public function GetMataAnggaranDetails($MataAnggarans)
    {
        $MataAnggaranID = $MataAnggarans->pluck('id');

        $MataAnggarans->map(function($MataAnggaran) {
            return $MataAnggaran;
        });
        return $MataAnggarans;
    }

}
