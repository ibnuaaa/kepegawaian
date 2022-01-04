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
                'name' => 'material_request',
                'label' => 'material_request',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'master_data',
                'label' => 'master_data',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'name' => 'material',
                'label' => 'material',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'name' => 'distributor',
                'label' => 'distributor',
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
                'name' => 'profile',
                'label' => 'profile',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 7,
                'name' => 'position',
                'label' => 'position',
                'created_at' => Carbon::now()
            ],
            [
                'id' => 8,
                'name' => 'change_password',
                'label' => 'change_password',
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
        $Exists = DB::table('permissions')
            ->whereIn($this->key, $this->Permissions
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Permissions->diffKeys($Exists->toArray())->values();
        DB::table('permissions')->insert($New->all());

    }
}
