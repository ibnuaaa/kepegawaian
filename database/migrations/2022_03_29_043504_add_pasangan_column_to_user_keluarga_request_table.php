<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasanganColumnToUserKeluargaRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_keluarga_request', function (Blueprint $table) {            //
            $table->string('nip')->nullable()->default(null)->after('nik');
            $table->string('no_akta_nikah')->nullable()->default(null)->after('nip');
            $table->date('tgl_pernikahan')->nullable()->default(null)->after('no_akta_nikah');
            $table->string('alamat')->nullable()->default(null)->after('tgl_pernikahan');
            $table->string('hp')->nullable()->default(null)->after('alamat');
            $table->string('status_pasangan')->nullable()->default(null)->after('hp');
            $table->string('no_akta_cerai_meninggal')->nullable()->default(null)->after('status_pasangan');
            $table->date('tgl_akta_cerai_meninggal')->nullable()->default(null)->after('no_akta_cerai_meninggal');
            $table->string('akta_kelahiran')->nullable()->default(null)->after('tgl_akta_cerai_meninggal');
            $table->string('status_pekerjaan_id')->nullable()->default(null)->after('akta_kelahiran');
            $table->string('status_anak_id')->nullable()->default(null)->after('status_pekerjaan_id');
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
