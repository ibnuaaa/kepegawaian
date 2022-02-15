<?php

namespace App\Traits\StatusPegawai;

/* Models */
use App\Models\StatusPegawai;

use DB;

trait StatusPegawaiCollection
{
    public function __construct()
    {
        $this->StatusPegawaiModel = StatusPegawai::class;
        $this->StatusPegawaiTable = getTable($this->StatusPegawaiModel);
    }

    public function GetStatusPegawaiDetails($StatusPegawais)
    {
        $StatusPegawaiID = $StatusPegawais->pluck('id');

        $StatusPegawais->map(function($StatusPegawai) {
            return $StatusPegawai;
        });
        return $StatusPegawais;
    }

}
