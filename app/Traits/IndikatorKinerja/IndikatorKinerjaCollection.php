<?php

namespace App\Traits\IndikatorKinerja;

/* Models */
use App\Models\IndikatorKinerja;

use DB;

trait IndikatorKinerjaCollection
{
    public function __construct()
    {
        $this->IndikatorKinerjaModel = IndikatorKinerja::class;
        $this->IndikatorKinerjaTable = getTable($this->IndikatorKinerjaModel);
    }

    public function GetIndikatorKinerjaDetails($IndikatorKinerjas)
    {
        $IndikatorKinerjaID = $IndikatorKinerjas->pluck('id');

        $IndikatorKinerjas->map(function($IndikatorKinerja) {
            return $IndikatorKinerja;
        });
        return $IndikatorKinerjas;
    }

}
