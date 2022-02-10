<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    protected $key = 'id';
    protected $Permissions = [];

    public function __construct()
    {
        $this->Permissions = collect([
            [
                'id' => 1,
                'name' => 'modul_pengguna',
                'label' => 'modul_pengguna',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'profile',
                'label' => 'profile',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'name' => 'change_password',
                'label' => 'change_password',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'name' => 'hak_akses',
                'label' => 'hak_akses',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'name' => 'user',
                'label' => 'user',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 6,
                'name' => 'master_data',
                'label' => 'master_data',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 7,
                'name' => 'golongan',
                'label' => 'golongan',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 8,
                'name' => 'indikator_kinerja',
                'label' => 'indikator_kinerja',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 9,
                'name' => 'unit_kerja',
                'label' => 'unit_kerja',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 10,
                'name' => 'jabatan',
                'label' => 'jabatan',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 11,
                'name' => 'pendidikan',
                'label' => 'pendidikan',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 12,
                'name' => 'indikator_tetap',
                'label' => 'indikator_tetap',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 13,
                'name' => 'penilaian_perilaku_kerja',
                'label' => 'penilaian_perilaku_kerja',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 14,
                'name' => 'jabatan_fungsional',
                'label' => 'jabatan_fungsional',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 15,
                'name' => 'user_request_sdm',
                'label' => 'user_request_sdm',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 16,
                'name' => 'report_skp',
                'label' => 'report_skp',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 17,
                'name' => 'user_request_diklat',
                'label' => 'user_request_diklat',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 18,
                'name' => 'penilaian_prestasi_kerja',
                'label' => 'penilaian_prestasi_kerja',
                'created_at' => Carbon::now()
            ]
        ])->keyBy($this->key);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         foreach ($this->Permissions as $key => $value) {
             $Exists = DB::table('permissions')
                 ->where('id', $value['id'])->first();

             if ($Exists) {
                 DB::table('permissions')
                 ->where('id', $value['id'])
                 ->update([
                     'name' => $value['name'],
                     'label' => $value['label'],
                 ]);
             } else {
                 DB::table('permissions')
                 ->insert([
                     'id' => $value['id'],
                     'name' => $value['name'],
                     'label' => $value['label'],
                 ]);
             }
         }
     }
}
