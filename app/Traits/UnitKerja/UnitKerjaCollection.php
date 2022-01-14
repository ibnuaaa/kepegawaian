<?php

namespace App\Traits\UnitKerja;

/* Models */
use App\Models\UnitKerja;

use DB;

trait UnitKerjaCollection
{
    public function __construct()
    {
        $this->UnitKerjaModel = UnitKerja::class;
        $this->UnitKerjaTable = getTable($this->UnitKerjaModel);
    }

    public function GetUnitKerjaDetails($UnitKerjas)
    {
        $UnitKerjaID = $UnitKerjas->pluck('id');

        $UnitKerjas->map(function($UnitKerja) {
            return $UnitKerja;
        });
        return $UnitKerjas;
    }

}
