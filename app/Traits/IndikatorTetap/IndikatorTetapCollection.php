<?php

namespace App\Traits\IndikatorTetap;

/* Models */
use App\Models\IndikatorTetap;

use DB;

trait IndikatorTetapCollection
{
    public function __construct()
    {
        $this->IndikatorTetapModel = IndikatorTetap::class;
        $this->IndikatorTetapTable = getTable($this->IndikatorTetapModel);
    }

    public function GetIndikatorTetapDetails($IndikatorTetaps)
    {
        $IndikatorTetapID = $IndikatorTetaps->pluck('id');

        $IndikatorTetaps->map(function($IndikatorTetap) {
            return $IndikatorTetap;
        });
        return $IndikatorTetaps;
    }

}
