<?php

namespace App\Traits\PenilaianPrestasiKerjaApproval;

/* Models */
use App\Models\PenilaianPrestasiKerjaApproval;

use DB;

trait PenilaianPrestasiKerjaApprovalCollection
{
    public function __construct()
    {
        $this->PenilaianPrestasiKerjaApprovalModel = PenilaianPrestasiKerjaApproval::class;
        $this->PenilaianPrestasiKerjaApprovalTable = getTable($this->PenilaianPrestasiKerjaApprovalModel);
    }

    public function GetPenilaianPrestasiKerjaApprovalDetails($PenilaianPrestasiKerjaApprovals)
    {
        $PenilaianPrestasiKerjaApprovalID = $PenilaianPrestasiKerjaApprovals->pluck('id');

        $PenilaianPrestasiKerjaApprovals->map(function($PenilaianPrestasiKerjaApproval) {
            return $PenilaianPrestasiKerjaApproval;
        });
        return $PenilaianPrestasiKerjaApprovals;
    }

}
