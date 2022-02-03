<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGolonganChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_golongan_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_golongan_id')->nullable()->default(NULL);
            $table->integer('user_id')->nullable()->default(NULL);
            $table->string('nama_golongan')->nullable()->default(NULL);
            $table->string('dari_tahun')->nullable()->default(NULL);
            $table->string('sampai_tahun')->nullable()->default(NULL);
            $table->date('tmt')->nullable()->default(NULL);
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
        Schema::dropIfExists('user_golongan_change');
    }
}
