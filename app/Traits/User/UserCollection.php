<?php

namespace App\Traits\User;

/* Models */
use App\Models\User;
use App\Models\Position;;

use DB;

trait UserCollection
{
    public function __construct()
    {
        $this->UserModel = User::class;
        $this->UserTable = getTable($this->UserModel);

        $this->PositionModel = Position::class;
        $this->PositionTable = getTable($this->PositionModel);

    }

    public function GetUserDetails($Users)
    {
        $UserID = $Users->pluck('id');

        $Users->map(function($User) {
            return $User;
        });
        return $Users;
    }

}
