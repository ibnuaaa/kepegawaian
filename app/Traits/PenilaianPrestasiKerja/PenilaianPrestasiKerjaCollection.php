<?php

namespace App\Traits\PenilaianPrestasiKerja;

/* Models */
use App\Models\PenilaianPrestasiKerja;

use DB;

trait PenilaianPrestasiKerjaCollection
{
    public function __construct()
    {
        $this->PenilaianPrestasiKerjaModel = PenilaianPrestasiKerja::class;
        $this->PenilaianPrestasiKerjaTable = getTable($this->PenilaianPrestasiKerjaModel);
    }

    public function GetPenilaianPrestasiKerjaDetails($PenilaianPrestasiKerjas)
    {
        $PenilaianPrestasiKerjaID = $PenilaianPrestasiKerjas->pluck('id');

        $PenilaianPrestasiKerjas->map(function($PenilaianPrestasiKerja) {
            return $PenilaianPrestasiKerja;
        });
        return $PenilaianPrestasiKerjas;
    }

}
