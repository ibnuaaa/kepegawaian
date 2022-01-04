<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    protected $key = 'id';
    protected $Configs = [];

    public function __construct()
    {
        $this->Configs = collect([
            [
                'id' => 1,
                'key' => 'protocol',
                'value' => 'http',
                'created_at' => Carbon::now()
            ],
        ])->keyBy($this->key);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Exists = DB::table('config')
            ->whereIn($this->key, $this->Configs
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Configs->diffKeys($Exists->toArray())->values();
        DB::table('config')->insert($New->all());

    }
}
