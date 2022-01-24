<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCreatedUserIdToIndikatorKinerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indikator_kinerja', function (Blueprint $table) {
            //
            $table->string('created_user_id')->nullable()->default(null)->after('unit_kerja_id');
            $table->string('created_jabatan_id')->nullable()->default(null)->after('created_user_id');
            $table->string('tipe_indikator')->nullable()->default(null)->after('created_jabatan_id');
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
