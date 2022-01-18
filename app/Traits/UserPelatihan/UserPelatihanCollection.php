<?php

namespace App\Traits\UserPelatihan;

/* Models */
use App\Models\UserPelatihan;

use DB;

trait UserPelatihanCollection
{
    public function __construct()
    {
        $this->UserPelatihanModel = UserPelatihan::class;
        $this->UserPelatihanTable = getTable($this->UserPelatihanModel);
    }

    public function GetUserPelatihanDetails($UserPelatihans)
    {
        $UserPelatihanID = $UserPelatihans->pluck('id');

        $UserPelatihans->map(function($UserPelatihan) {
            return $UserPelatihan;
        });
        return $UserPelatihans;
    }

}
