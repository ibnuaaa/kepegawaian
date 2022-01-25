<?php

namespace App\Traits\PenilaianPrestasiKerjaItem;

/* Models */
use App\Models\PenilaianPrestasiKerjaItem;

use DB;

trait PenilaianPrestasiKerjaItemCollection
{
    public function __construct()
    {
        $this->PenilaianPrestasiKerjaItemModel = PenilaianPrestasiKerjaItem::class;
        $this->PenilaianPrestasiKerjaItemTable = getTable($this->PenilaianPrestasiKerjaItemModel);
    }

    public function GetPenilaianPrestasiKerjaItemDetails($PenilaianPrestasiKerjaItems)
    {
        $PenilaianPrestasiKerjaItemID = $PenilaianPrestasiKerjaItems->pluck('id');

        $PenilaianPrestasiKerjaItems->map(function($PenilaianPrestasiKerjaItem) {
            return $PenilaianPrestasiKerjaItem;
        });
        return $PenilaianPrestasiKerjaItems;
    }

}
