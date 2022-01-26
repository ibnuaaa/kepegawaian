<?php

namespace App\Traits\PerilakuKerja;

/* Models */
use App\Models\PerilakuKerja;

use DB;

trait PerilakuKerjaCollection
{
    public function __construct()
    {
        $this->PerilakuKerjaModel = PerilakuKerja::class;
        $this->PerilakuKerjaTable = getTable($this->PerilakuKerjaModel);
    }

    public function GetPerilakuKerjaDetails($PerilakuKerjas)
    {
        $PerilakuKerjaID = $PerilakuKerjas->pluck('id');

        $PerilakuKerjas->map(function($PerilakuKerja) {
            return $PerilakuKerja;
        });
        return $PerilakuKerjas;
    }

}
