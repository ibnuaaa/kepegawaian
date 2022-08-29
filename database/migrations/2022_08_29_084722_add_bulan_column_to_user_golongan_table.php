<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulanColumnToUserGolonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_golongan', function (Blueprint $table) {
            //
            $table->string('dari_bulan')->nullable()->after('dari_tahun');
            $table->string('sampai_bulan')->nullable()->after('sampai_tahun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_golongan', function (Blueprint $table) {
            //
        });
    }
}
