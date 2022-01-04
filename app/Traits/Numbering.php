<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\BranchToConfigNumbering;
use App\Models\ConfigNumbering;

trait Numbering
{
    public function getTransactionNumber($type, $year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }
        $ConfigNumbering = ConfigNumbering::where('type', $type)->where('year',$year)->first();
        if(!$ConfigNumbering) {
            $this->addNewConfigNumbering($type, $year);
        }

        $ConfigNumbering = ConfigNumbering::where('type', $type)->where('year',$year)->first();
        $length = $ConfigNumbering->length;
        $lastValue = $ConfigNumbering->last_value;

        $last_value = $this->addTransactionNumber($type, $ConfigNumbering->last_value, $year);

        $transactionNumber = str_pad((int) $last_value, (int)$length, '0', STR_PAD_LEFT);
        $transactionNumber = $transactionNumber;
        return [
            'success' => true,
            'value' => $transactionNumber,
            'last_value' => $ConfigNumbering->last_value
        ];
    }

    public function getLastTransactionNumber($type, $year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }
        $ConfigNumbering = ConfigNumbering::where('type', $type)->where('year',$year)->first();
        if(!$ConfigNumbering) {
            $this->addNewConfigNumbering($type);
        }

        $ConfigNumbering = ConfigNumbering::where('type', $type)->where('year',$year)->first();
        $length = $ConfigNumbering->length;
        $lastValue = 0;
        if (!empty($ConfigNumbering->last_value)) {
            $lastValue = $ConfigNumbering->last_value;
        }

        return [
            'success' => true,
            'last_value' => $lastValue
        ];
    }

    public function addTransactionNumber($type, $lastTransactionNumber, $year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        $ConfigNumbering = ConfigNumbering::where('type', $type)->where('year',$year)->first();
        if (!$ConfigNumbering) {
            $ConfigNumbering = new ConfigNumbering();
            $ConfigNumbering->type = $type;
            $ConfigNumbering->length = 4;
            $ConfigNumbering->year = $year;
            $ConfigNumbering->save();
        }

        $lastNumber = 0;
        if(!empty($ConfigNumbering->last_value)){
            $lastNumber = $ConfigNumbering->last_value;
        }
        $last_value =  $lastNumber + 1;

        $ConfigNumbering->last_value = $last_value;
        $ConfigNumbering->save();

        return $last_value;
    }

    public function addNewConfigNumbering($type, $year = null) {
        if (empty($year)) {
            $year = date('Y');
        }

        $ConfigNumbering = new ConfigNumbering();
        $ConfigNumbering->type = $type;
        $ConfigNumbering->length = 4;
        $ConfigNumbering->year = $year;
        $ConfigNumbering->save();

        return $ConfigNumbering;
    }
}
