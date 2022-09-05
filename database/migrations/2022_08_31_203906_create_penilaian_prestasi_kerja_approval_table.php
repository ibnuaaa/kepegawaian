<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianPrestasiKerjaApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_prestasi_kerja_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('penilaian_prestasi_kerja_id')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(NULL);
            $table->integer('status')->nullable()->default(NULL);
            $table->integer('read_at')->nullable()->default(NULL);
            $table->timestamp('approved_at')->nullable()->default(NULL);
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
    }
}
