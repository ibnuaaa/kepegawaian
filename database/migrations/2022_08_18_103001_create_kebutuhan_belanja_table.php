<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKebutuhanBelanjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kebutuhan_belanja', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->nullable()->default(NULL);
          $table->integer('unit_kerja_id')->nullable()->default(null);
          $table->integer('tahun_anggaran')->nullable()->default(null);
          $table->integer('kegiatan_indikator_kinerja_id')->nullable()->default(NULL);
          $table->integer('koordinator_user_id')->nullable()->default(NULL);
          $table->integer('created_user_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('kebutuhan_belanja');
    }
}
