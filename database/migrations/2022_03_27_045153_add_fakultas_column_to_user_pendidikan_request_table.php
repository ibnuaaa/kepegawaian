<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFakultasColumnToUserPendidikanRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_pendidikan_request', function (Blueprint $table) {
            //
            $table->string('fakultas')->nullable()->default(null)->after('pendidikan_id');
            $table->string('nim')->nullable()->default(null)->after('fakultas');
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
