<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PositionPermissionSeeder extends Seeder
{
    protected $key = 'id';
    protected $PositionPermissions = [];

    public function __construct()
    {
        $this->PositionPermissions = collect([
            [
                'id' => 1,
                'position_id' => 1,
                'permission_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'position_id' => 1,
                'permission_id' => 2,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'position_id' => 1,
                'permission_id' => 3,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'position_id' => 1,
                'permission_id' => 4,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'position_id' => 1,
                'permission_id' => 5,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 6,
                'position_id' => 1,
                'permission_id' => 6,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 7,
                'position_id' => 1,
                'permission_id' => 7,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 8,
                'position_id' => 1,
                'permission_id' => 8,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 9,
                'position_id' => 1,
                'permission_id' => 9,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 10,
                'position_id' => 1,
                'permission_id' => 10,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 11,
                'position_id' => 1,
                'permission_id' => 11,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 12,
                'position_id' => 1,
                'permission_id' => 12,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 13,
                'position_id' => 1,
                'permission_id' => 13,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 14,
                'position_id' => 1,
                'permission_id' => 14,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 15,
                'position_id' => 1,
                'permission_id' => 15,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 16,
                'position_id' => 1,
                'permission_id' => 16,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 17,
                'position_id' => 1,
                'permission_id' => 17,
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
         foreach ($this->PositionPermissions as $key => $value) {
             $Exists = DB::table('position_permissions')
                 ->where('position_id', $value['position_id'])
                 ->where('permission_id', $value['permission_id'])
                 ->first();

             if (!$Exists) {
                 DB::table('position_permissions')
                 ->insert([
                     'position_id' => $value['position_id'],
                     'permission_id' => $value['permission_id'],
                 ]);
             }
         }
     }
}
