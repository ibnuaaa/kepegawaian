<?php

namespace App\Traits\UserPendidikan;

/* Models */
use App\Models\UserPendidikan;

use DB;

trait UserPendidikanCollection
{
    public function __construct()
    {
        $this->UserPendidikanModel = UserPendidikan::class;
        $this->UserPendidikanTable = getTable($this->UserPendidikanModel);
    }

    public function GetUserPendidikanDetails($UserPendidikans)
    {
        $UserPendidikanID = $UserPendidikans->pluck('id');

        $UserPendidikans->map(function($UserPendidikan) {
            return $UserPendidikan;
        });
        return $UserPendidikans;
    }

}
