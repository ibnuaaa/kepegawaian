<?php

namespace App\Traits\JabatanFungsional;

/* Models */
use App\Models\JabatanFungsional;

use DB;

trait JabatanFungsionalCollection
{
    public function __construct()
    {
        $this->JabatanFungsionalModel = JabatanFungsional::class;
        $this->JabatanFungsionalTable = getTable($this->JabatanFungsionalModel);
    }

    public function GetJabatanFungsionalDetails($JabatanFungsionals)
    {
        $JabatanFungsionalID = $JabatanFungsionals->pluck('id');

        $JabatanFungsionals->map(function($JabatanFungsional) {
            return $JabatanFungsional;
        });
        return $JabatanFungsionals;
    }

}
