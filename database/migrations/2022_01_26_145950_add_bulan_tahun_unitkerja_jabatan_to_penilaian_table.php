<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulanTahunUnitkerjaJabatanToPenilaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian_prestasi_kerja', function (Blueprint $table) {
            //
            $table->integer('bulan')->nullable()->default(null)->after('user_id');
            $table->integer('tahun')->nullable()->default(null)->after('bulan');
            $table->integer('jabatan_id')->nullable()->default(null)->after('tahun');
            $table->integer('unit_kerja_id')->nullable()->default(null)->after('jabatan_id');
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
