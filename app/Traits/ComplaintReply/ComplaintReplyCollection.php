<?php

namespace App\Traits\ComplaintReply;

/* Models */
use App\Models\ComplaintReply;

use DB;

trait ComplaintReplyCollection
{
    public function __construct()
    {
        $this->ComplaintReplyModel = ComplaintReply::class;
        $this->ComplaintReplyTable = getTable($this->ComplaintReplyModel);
    }

    public function GetComplaintReplyDetails($ComplaintReplys)
    {
        $ComplaintReplyID = $ComplaintReplys->pluck('id');

        $ComplaintReplys->map(function($ComplaintReply) {
            return $ComplaintReply;
        });
        return $ComplaintReplys;
    }

}
