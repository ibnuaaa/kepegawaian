<?php

namespace App\Traits\Jabatan;

/* Models */
use App\Models\Jabatan;
use App\Models\User;

use DB;

trait JabatanCollection
{



    public function __construct()
    {
        $this->JabatanModel = Jabatan::class;
        $this->JabatanTable = getTable($this->JabatanModel);

        $this->UserModel = User::class;
        $this->UserTable = getTable($this->UserModel);

    }

    public function GetJabatanDetails($Jabatans)
    {
        $JabatanID = $Jabatans->pluck('id');

        $Jabatans->map(function($Jabatan) {
            return $Jabatan;
        });

        // cetak($Jabatans->toArray());
        // die();

        return $Jabatans;
    }

    public function getSelection($data, $arr = []) {

        $item = $data;
        unset($item['parents']);
        $arr[] = $item;

        if ($data['parents']) return $this->getSelection($data['parents'], $arr);
        else return $arr ;
    }



}
