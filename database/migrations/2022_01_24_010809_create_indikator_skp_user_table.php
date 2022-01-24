<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndikatorSkpUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indikator_skp_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(NULL);
            $table->integer('indikator_kinerja_id')->nullable()->default(NULL);
            $table->decimal('bobot', 16,2)->nullable()->default(NULL);
            $table->decimal('target', 16,2)->nullable()->default(NULL);
            $table->decimal('realisasi', 16,2)->nullable()->default(NULL);
            $table->decimal('capaian', 16,2)->nullable()->default(NULL);
            $table->decimal('nilai_kinerja', 16,2)->nullable()->default(NULL);
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
        Schema::dropIfExists('indikator_skp_user');
    }
}
