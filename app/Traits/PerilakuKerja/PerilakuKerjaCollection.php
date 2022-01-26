<?php

namespace App\Traits\Golongan;

/* Models */
use App\Models\Golongan;

use DB;

trait GolonganCollection
{
    public function __construct()
    {
        $this->GolonganModel = Golongan::class;
        $this->GolonganTable = getTable($this->GolonganModel);
    }

    public function GetGolonganDetails($Golongans)
    {
        $GolonganID = $Golongans->pluck('id');

        $Golongans->map(function($Golongan) {
            return $Golongan;
        });
        return $Golongans;
    }

}
