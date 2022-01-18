<?php

namespace App\Traits\UserJabatan;

/* Models */
use App\Models\UserJabatan;

use DB;

trait UserJabatanCollection
{
    public function __construct()
    {
        $this->UserJabatanModel = UserJabatan::class;
        $this->UserJabatanTable = getTable($this->UserJabatanModel);
    }

    public function GetUserJabatanDetails($UserJabatans)
    {
        $UserJabatanID = $UserJabatans->pluck('id');

        $UserJabatans->map(function($UserJabatan) {
            return $UserJabatan;
        });
        return $UserJabatans;
    }

}
