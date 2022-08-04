<?php

namespace App\Traits\EKinerjaIki;

/* Models */
use App\Models\EKinerjaIki;

use DB;

trait EKinerjaIkiCollection
{
    public function __construct()
    {
        $this->EKinerjaIkiModel = EKinerjaIki::class;
        $this->EKinerjaIkiTable = getTable($this->EKinerjaIkiModel);
    }

    public function GetEKinerjaIkiDetails($EKinerjaIkis)
    {
        $EKinerjaIkiID = $EKinerjaIkis->pluck('id');

        $EKinerjaIkis->map(function($EKinerjaIki) {
            return $EKinerjaIki;
        });
        return $EKinerjaIkis;
    }

}
