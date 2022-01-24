<?php

namespace App\Traits\IndikatorSkp;

/* Models */
use App\Models\IndikatorSkp;

use DB;

trait IndikatorSkpCollection
{
    public function __construct()
    {
        $this->IndikatorSkpModel = IndikatorSkp::class;
        $this->IndikatorSkpTable = getTable($this->IndikatorSkpModel);
    }

    public function GetIndikatorSkpDetails($IndikatorSkps)
    {
        $IndikatorSkpID = $IndikatorSkps->pluck('id');

        $IndikatorSkps->map(function($IndikatorSkp) {
            return $IndikatorSkp;
        });
        return $IndikatorSkps;
    }

}
