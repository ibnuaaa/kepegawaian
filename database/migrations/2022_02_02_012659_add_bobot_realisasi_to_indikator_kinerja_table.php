<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBobotRealisasiToIndikatorKinerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indikator_kinerja', function (Blueprint $table) {
            //
            $table->decimal('bobot', 16, 2)->nullable()->default(null)->after('unit_kerja_id');
            $table->decimal('target', 16, 2)->nullable()->default(null)->after('bobot');
            $table->decimal('realisasi', 16, 2)->nullable()->default(null)->after('target');
            $table->decimal('capaian', 16, 2)->nullable()->default(null)->after('realisasi');
            $table->decimal('nilai_kinerja', 16, 2)->nullable()->default(null)->after('capaian');
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
