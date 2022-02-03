<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(NULL);
            $table->string('username')->nullable()->default(null);
            $table->integer('jabatan_id')->nullable()->default(null);
            $table->string('jabatan_fungsional_id')->nullable()->default(null);
            $table->string('nip')->nullable()->default(null);
            $table->string('no_ktp')->nullable()->default(null);
            $table->date('tanggal_lahir')->nullable()->default(null);
            $table->string('tempat_lahir')->nullable()->default(null);
            $table->string('alamat')->nullable()->default(null);
            $table->string('kode_pos')->nullable()->default(null);
            $table->string('telepon')->nullable()->default(null);
            $table->string('hp')->nullable()->default(null);
            $table->string('npwp')->nullable()->default(null);
            $table->string('no_rekening')->nullable()->default(null);
            $table->string('golongan_darah')->nullable()->default(null);
            $table->integer('status_perkawinan_id')->nullable()->default(null);
            $table->integer('golongan_id')->nullable()->default(null);
            $table->integer('unit_kerja_id')->nullable()->default(null);
            $table->integer('pendidikan_id')->nullable()->default(null);
            $table->string('pendidikan_detail')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
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
        Schema::dropIfExists('user_change');
    }
}
