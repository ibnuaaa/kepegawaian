<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRealisasiApproveColumnToPenilaianPrestasiItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian_prestasi_kerja_item', function (Blueprint $table) {
            //
            $table->decimal('realisasi_approved', 16,2)->nullable()->after('realisasi');
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
