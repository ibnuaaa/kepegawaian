<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_anggaran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->string('unit_kerja_id')->nullable()->default(null);
            $table->integer('parent_id')->nullable()->default(NULL);
            $table->integer('created_user_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('mata_anggaran');
    }
}
