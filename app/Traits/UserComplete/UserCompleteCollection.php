<?php

namespace App\Traits\UserComplete;

/* Models */
use App\Models\UserComplete;
use App\Models\Position;;

use DB;

trait UserCompleteCollection
{
    public function __construct()
    {
        $this->UserCompleteModel = UserComplete::class;
        $this->UserCompleteTable = getTable($this->UserCompleteModel);

        $this->PositionModel = Position::class;
        $this->PositionTable = getTable($this->PositionModel);

    }

    public function GetUserCompleteDetails($UserCompletes)
    {
        $UserCompleteID = $UserCompletes->pluck('id');

        $UserCompletes->map(function($UserComplete) {
            return $UserComplete;
        });
        return $UserCompletes;
    }

}
