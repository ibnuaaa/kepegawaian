<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianIkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_iku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('penilaian_prestasi_kerja_id');
            $table->decimal('target',16,3)->nullable()->default(NULL);
            $table->decimal('realisasi', 16,3)->nullable()->default(NULL);
            $table->decimal('capaian_unit', 16,3)->nullable()->default(NULL);
            $table->decimal('iku', 16,3)->nullable()->default(NULL);
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian_iku');
    }
}
