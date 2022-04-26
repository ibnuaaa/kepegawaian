<?php

namespace App\Traits\Kampus;

/* Models */
use App\Models\Kampus;

use DB;

trait KampusCollection
{
    public function __construct()
    {
        $this->KampusModel = Kampus::class;
        $this->KampusTable = getTable($this->KampusModel);
    }

    public function GetKampusDetails($Kampuss)
    {
        $KampusID = $Kampuss->pluck('id');

        $Kampuss->map(function($Kampus) {
            return $Kampus;
        });
        return $Kampuss;
    }

}
