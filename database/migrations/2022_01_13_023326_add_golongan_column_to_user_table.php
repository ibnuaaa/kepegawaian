<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGolonganColumnToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('no_ktp')->nullable()->default(null)->after('nip');
            $table->date('tanggal_lahir')->nullable()->default(null)->after('no_ktp');
            $table->string('tempat_lahir')->nullable()->default(null)->after('tanggal_lahir');
            $table->string('alamat')->nullable()->default(null)->after('tempat_lahir');
            $table->string('kode_pos')->nullable()->default(null)->after('alamat');
            $table->string('telepon')->nullable()->default(null)->after('kode_pos');
            $table->string('hp')->nullable()->default(null)->after('telepon');
            $table->string('npwp')->nullable()->default(null)->after('hp');
            $table->string('no_rekening')->nullable()->default(null)->after('npwp');
            $table->string('golongan_darah')->nullable()->default(null)->after('no_rekening');
            $table->integer('status_perkawinan_id')->nullable()->default(null)->after('golongan_darah');
            $table->integer('golongan_id')->nullable()->default(null)->after('status_perkawinan_id');
            $table->integer('unit_kerja_id')->nullable()->default(null)->after('golongan_id');
            $table->integer('pendidikan_id')->nullable()->default(null)->after('unit_kerja_id');
            $table->string('pendidikan_detail')->nullable()->default(null)->after('pendidikan_id');
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
