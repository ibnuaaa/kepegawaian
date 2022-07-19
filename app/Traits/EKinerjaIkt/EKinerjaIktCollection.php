<?php

namespace App\Traits\EKinerjaIkt;

/* Models */
use App\Models\EKinerjaIkt;

use DB;

trait EKinerjaIktCollection
{
    public function __construct()
    {
        $this->EKinerjaIktModel = EKinerjaIkt::class;
        $this->EKinerjaIktTable = getTable($this->EKinerjaIktModel);
    }

    public function GetEKinerjaIktDetails($EKinerjaIkts)
    {
        $EKinerjaIktID = $EKinerjaIkts->pluck('id');

        $EKinerjaIkts->map(function($EKinerjaIkt) {
            return $EKinerjaIkt;
        });
        return $EKinerjaIkts;
    }

}
