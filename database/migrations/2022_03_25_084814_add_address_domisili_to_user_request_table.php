<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressDomisiliToUserRequestTable extends Migration
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
            $table->string('alamat_domisili')->nullable()->default(null)->after('alamat');
            $table->string('kode_pos_domisili')->nullable()->default(null)->after('alamat_domisili');
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
