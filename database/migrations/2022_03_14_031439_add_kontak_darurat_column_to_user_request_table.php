<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKontakDaruratColumnToUserRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_request', function (Blueprint $table) {
            //
            $table->string('nama_kontak_darurat')->nullable()->default(null)->after('hp');
            $table->string('hubungan_kontak_darurat')->nullable()->default(null)->after('nama_kontak_darurat');
            $table->string('no_handphone_kontak_darurat')->nullable()->default(null)->after('hubungan_kontak_darurat');
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
