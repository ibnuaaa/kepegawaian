<?php

namespace App\Traits\ComplaintTo;

/* Models */
use App\Models\ComplaintTo;

use DB;

trait ComplaintToCollection
{
    public function __construct()
    {
        $this->ComplaintToModel = ComplaintTo::class;
        $this->ComplaintToTable = getTable($this->ComplaintToModel);
    }

    public function GetComplaintToDetails($ComplaintTos)
    {
        $ComplaintToID = $ComplaintTos->pluck('id');

        $ComplaintTos->map(function($ComplaintTo) {
            return $ComplaintTo;
        });
        return $ComplaintTos;
    }

}
