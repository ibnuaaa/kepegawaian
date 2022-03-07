<?php

namespace App\Traits\UserRequestReject;

/* Models */
use App\Models\UserRequestReject;

use DB;

trait UserRequestRejectCollection
{
    public function __construct()
    {
        $this->UserRequestRejectModel = UserRequestReject::class;
        $this->UserRequestRejectTable = getTable($this->UserRequestRejectModel);
    }

    public function GetUserRequestRejectDetails($UserRequestRejects)
    {
        $UserRequestRejectID = $UserRequestRejects->pluck('id');

        $UserRequestRejects->map(function($UserRequestReject) {
            return $UserRequestReject;
        });
        return $UserRequestRejects;
    }

}
