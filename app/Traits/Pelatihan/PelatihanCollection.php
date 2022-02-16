<?php

namespace App\Traits\Pelatihan;

/* Models */
use App\Models\Pelatihan;

use DB;

trait PelatihanCollection
{
    public function __construct()
    {
        $this->PelatihanModel = Pelatihan::class;
        $this->PelatihanTable = getTable($this->PelatihanModel);
    }

    public function GetPelatihanDetails($Pelatihans)
    {
        $PelatihanID = $Pelatihans->pluck('id');

        $Pelatihans->map(function($Pelatihan) {
            return $Pelatihan;
        });
        return $Pelatihans;
    }

}
