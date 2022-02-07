<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBobotColumnToIndikatorTetapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indikator_tetap', function (Blueprint $table) {
            //
            $table->decimal('bobot_pimpinan')->nullable()->default(null)->after('name');
            $table->decimal('bobot_staff')->nullable()->default(null)->after('bobot_pimpinan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
