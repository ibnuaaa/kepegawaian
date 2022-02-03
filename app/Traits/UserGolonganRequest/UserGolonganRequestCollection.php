<?php

namespace App\Traits\UserGolonganRequest;

/* Models */
use App\Models\UserGolonganRequest;

use DB;

trait UserGolonganRequestCollection
{
    public function __construct()
    {
        $this->UserGolonganRequestModel = UserGolonganRequest::class;
        $this->UserGolonganRequestTable = getTable($this->UserGolonganRequestModel);
    }

    public function GetUserGolonganRequestDetails($UserGolonganRequests)
    {
        $UserGolonganRequestID = $UserGolonganRequests->pluck('id');

        $UserGolonganRequests->map(function($UserGolonganRequest) {
            return $UserGolonganRequest;
        });
        return $UserGolonganRequests;
    }

}
