<?php

namespace App\Traits\UserKeluarga;

/* Models */
use App\Models\UserKeluarga;

use DB;

trait UserKeluargaCollection
{
    public function __construct()
    {
        $this->UserKeluargaModel = UserKeluarga::class;
        $this->UserKeluargaTable = getTable($this->UserKeluargaModel);
    }

    public function GetUserKeluargaDetails($UserKeluargas)
    {
        $UserKeluargaID = $UserKeluargas->pluck('id');

        $UserKeluargas->map(function($UserKeluarga) {
            return $UserKeluarga;
        });
        return $UserKeluargas;
    }

}
