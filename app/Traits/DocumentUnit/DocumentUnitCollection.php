<?php

namespace App\Traits\DocumentUnit;

/* Models */
use App\Models\DocumentUnit;

use DB;

trait DocumentUnitCollection
{
    public function __construct()
    {
        $this->DocumentUnitModel = DocumentUnit::class;
        $this->DocumentUnitTable = getTable($this->DocumentUnitModel);
    }

    public function GetDocumentUnitDetails($DocumentUnits)
    {
        $DocumentUnitID = $DocumentUnits->pluck('id');

        $DocumentUnits->map(function($DocumentUnit) {
            return $DocumentUnit;
        });
        return $DocumentUnits;
    }

}
