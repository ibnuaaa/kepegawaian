<?php

namespace App\Traits\UserKeluargaRequest;

/* Models */
use App\Models\UserKeluargaRequest;

use DB;

trait UserKeluargaRequestCollection
{
    public function __construct()
    {
        $this->UserKeluargaRequestModel = UserKeluargaRequest::class;
        $this->UserKeluargaRequestTable = getTable($this->UserKeluargaRequestModel);
    }

    public function GetUserKeluargaRequestDetails($UserKeluargaRequests)
    {
        $UserKeluargaRequestID = $UserKeluargaRequests->pluck('id');

        $UserKeluargaRequests->map(function($UserKeluargaRequest) {
            return $UserKeluargaRequest;
        });
        return $UserKeluargaRequests;
    }

}
