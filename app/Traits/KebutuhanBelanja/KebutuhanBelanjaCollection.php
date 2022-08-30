<?php

namespace App\Traits\Pendidikan;

/* Models */
use App\Models\Pendidikan;

use DB;

trait PendidikanCollection
{
    public function __construct()
    {
        $this->PendidikanModel = Pendidikan::class;
        $this->PendidikanTable = getTable($this->PendidikanModel);
    }

    public function GetPendidikanDetails($Pendidikans)
    {
        $PendidikanID = $Pendidikans->pluck('id');

        $Pendidikans->map(function($Pendidikan) {
            return $Pendidikan;
        });
        return $Pendidikans;
    }

}
