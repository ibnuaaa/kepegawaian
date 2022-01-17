<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserKeluargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_keluarga', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nama_lengkap')->nullable()->default(NULL);
          $table->string('nik')->nullable()->default(NULL);
          $table->string('jenis_kelamin')->nullable()->default(NULL);
          $table->string('tempat_lahir')->nullable()->default(NULL);
          $table->string('tanggal_lahir')->nullable()->default(NULL);
          $table->integer('agama_id')->nullable()->default(NULL);
          $table->integer('pendidikan_id')->nullable()->default(NULL);
          $table->integer('jenis_pekerjaan_id')->nullable()->default(NULL);
          $table->integer('status_perkawinan_id')->nullable()->default(NULL);
          $table->integer('hubungan_keluarga_id')->nullable()->default(NULL);
          $table->integer('kewarganegaraan_id')->nullable()->default(NULL);
          $table->string('no_paspor')->nullable()->default(NULL);
          $table->string('no_kitas')->nullable()->default(NULL);
          $table->string('ayah')->nullable()->default(NULL);
          $table->string('ibu')->nullable()->default(NULL);
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
        Schema::dropIfExists('user_keluarga');
    }
}
