<?php

namespace App\Traits\UserPendidikanRequest;

/* Models */
use App\Models\UserPendidikanRequest;

use DB;

trait UserPendidikanRequestCollection
{
    public function __construct()
    {
        $this->UserPendidikanRequestModel = UserPendidikanRequest::class;
        $this->UserPendidikanRequestTable = getTable($this->UserPendidikanRequestModel);
    }

    public function GetUserPendidikanRequestDetails($UserPendidikanRequests)
    {
        $UserPendidikanRequestID = $UserPendidikanRequests->pluck('id');

        $UserPendidikanRequests->map(function($UserPendidikanRequest) {
            return $UserPendidikanRequest;
        });
        return $UserPendidikanRequests;
    }

}
