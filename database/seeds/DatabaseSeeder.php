<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Base
        $this->call('UserAdminSeeder');

        if (
            config('app.env') === 'testing' ||
            config('app.env') === 'development' ||
            config('app.env') === 'local') {
            // Only for testing
            $this->call('UserSeeder');
            $this->call('PositionSeeder');
            $this->call('PermissionSeeder');
            $this->call('PositionPermissionSeeder');
            $this->call('ConfigSeeder');
            // $this->call('RouletteWheelDataSeeder');
        } else {
            // Live
        }
    }
}
