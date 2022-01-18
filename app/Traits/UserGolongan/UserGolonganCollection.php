<?php

namespace App\Traits\UserGolongan;

/* Models */
use App\Models\UserGolongan;

use DB;

trait UserGolonganCollection
{
    public function __construct()
    {
        $this->UserGolonganModel = UserGolongan::class;
        $this->UserGolonganTable = getTable($this->UserGolonganModel);
    }

    public function GetUserGolonganDetails($UserGolongans)
    {
        $UserGolonganID = $UserGolongans->pluck('id');

        $UserGolongans->map(function($UserGolongan) {
            return $UserGolongan;
        });
        return $UserGolongans;
    }

}
