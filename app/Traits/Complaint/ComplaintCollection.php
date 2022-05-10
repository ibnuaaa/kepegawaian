<?php

namespace App\Traits\Complaint;

/* Models */
use App\Models\Complaint;

use DB;

trait ComplaintCollection
{
    public function __construct()
    {
        $this->ComplaintModel = Complaint::class;
        $this->ComplaintTable = getTable($this->ComplaintModel);
    }

    public function GetComplaintDetails($Complaints)
    {
        $ComplaintID = $Complaints->pluck('id');

        $Complaints->map(function($Complaint) {
            return $Complaint;
        });
        return $Complaints;
    }

}
