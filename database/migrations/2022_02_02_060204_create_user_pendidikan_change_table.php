<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPendidikanChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pendidikan_request', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_pendidikan_id')->nullable()->default(NULL);
          $table->integer('user_id')->nullable()->default(NULL);
          $table->integer('pendidikan_id')->nullable()->default(NULL);
          $table->string('pendidikan_detail')->nullable()->default(NULL);
          $table->string('no_ijazah')->nullable()->default(NULL);
          $table->string('tahun_lulus')->nullable()->default(NULL);
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
        Schema::dropIfExists('user_pendidikan_change');
    }
}
