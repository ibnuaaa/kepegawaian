<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEKinerjaIkiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_kinerja_iki_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('e_kinerja_iki_id');
            $table->string('category')->nullable()->default(NULL);
            $table->integer('no')->nullable()->default(NULL);
            $table->string('judul_indikator')->nullable()->default(NULL);
            $table->string('bobot')->nullable()->default(NULL);
            $table->text('standart')->nullable()->default(NULL);
            $table->text('haper')->nullable()->default(NULL);
            $table->string('skor')->nullable()->default(NULL);
            $table->string('total')->nullable()->default(NULL);            
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
        Schema::dropIfExists('e_kinerja_iki_detail');
    }
}
