<?php

namespace App\Traits\UserPelatihanRequest;

/* Models */
use App\Models\UserPelatihanRequest;

use DB;

trait UserPelatihanRequestCollection
{
    public function __construct()
    {
        $this->UserPelatihanRequestModel = UserPelatihanRequest::class;
        $this->UserPelatihanRequestTable = getTable($this->UserPelatihanRequestModel);
    }

    public function GetUserPelatihanRequestDetails($UserPelatihanRequests)
    {
        $UserPelatihanRequestID = $UserPelatihanRequests->pluck('id');

        $UserPelatihanRequests->map(function($UserPelatihanRequest) {
            return $UserPelatihanRequest;
        });
        return $UserPelatihanRequests;
    }

}
