<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatanFungsionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatan_fungsional', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->nullable()->default(NULL);
          $table->integer('parent_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('jabatan_fungsional');
    }
}
