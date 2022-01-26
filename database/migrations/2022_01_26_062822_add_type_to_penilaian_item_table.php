<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToPenilaianItemTable extends Migration
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
            $table->string('indikator_kinerja_text')->nullable()->default(null)->after('indikator_kinerja_id');
            $table->string('perilaku_kerja_id')->nullable()->default(null)->after('indikator_kinerja_text');
            $table->string('type')->nullable()->default(null)->after('perilaku_kerja_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_item', function (Blueprint $table) {
            //
        });
    }
}
