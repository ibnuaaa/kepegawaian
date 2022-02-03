<?php

namespace App\Traits\UserRequest;

/* Models */
use App\Models\UserRequest;
use App\Models\Position;;

use DB;

trait UserRequestCollection
{
    public function __construct()
    {
        $this->UserRequestModel = UserRequest::class;
        $this->UserRequestTable = getTable($this->UserRequestModel);

        $this->PositionModel = Position::class;
        $this->PositionTable = getTable($this->PositionModel);

    }

    public function GetUserRequestDetails($UserRequests)
    {
        $UserRequestID = $UserRequests->pluck('id');

        $UserRequests->map(function($UserRequest) {
            return $UserRequest;
        });
        return $UserRequests;
    }

}
