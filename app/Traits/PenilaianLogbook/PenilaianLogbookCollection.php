<?php

namespace App\Traits\PenilaianLogbook;

/* Models */
use App\Models\PenilaianLogbook;

use DB;

trait PenilaianLogbookCollection
{
    public function __construct()
    {
        $this->PenilaianLogbookModel = PenilaianLogbook::class;
        $this->PenilaianLogbookTable = getTable($this->PenilaianLogbookModel);
    }

    public function GetPenilaianLogbookDetails($PenilaianLogbooks)
    {
        $PenilaianLogbookID = $PenilaianLogbooks->pluck('id');

        $PenilaianLogbooks->map(function($PenilaianLogbook) {
            return $PenilaianLogbook;
        });
        return $PenilaianLogbooks;
    }

}
