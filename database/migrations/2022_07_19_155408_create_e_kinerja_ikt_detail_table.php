<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEKinerjaIktDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_kinerja_ikt_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('e_kinerja_ikt_id');
            $table->integer('no')->nullable()->default(NULL);
            $table->string('judul_indikator')->nullable()->default(NULL);
            $table->text('standart')->nullable()->default(NULL);
            $table->string('target')->nullable()->default(NULL);
            $table->string('realisasi')->nullable()->default(NULL);                        
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
        Schema::dropIfExists('e_kinerja_ikt_detail');
    }
}
