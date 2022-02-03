<?php

namespace App\Traits\UserJabatanRequest;

/* Models */
use App\Models\UserJabatanRequest;

use DB;

trait UserJabatanRequestCollection
{
    public function __construct()
    {
        $this->UserJabatanRequestModel = UserJabatanRequest::class;
        $this->UserJabatanRequestTable = getTable($this->UserJabatanRequestModel);
    }

    public function GetUserJabatanRequestDetails($UserJabatanRequests)
    {
        $UserJabatanRequestID = $UserJabatanRequests->pluck('id');

        $UserJabatanRequests->map(function($UserJabatanRequest) {
            return $UserJabatanRequest;
        });
        return $UserJabatanRequests;
    }

}
