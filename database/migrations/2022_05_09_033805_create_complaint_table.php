<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('from_user_id')->nullable()->default(NULL);
          $table->integer('from_unit_kerja_id')->nullable()->default(NULL);
          $table->string('title')->nullable()->default(NULL);
          $table->text('description')->nullable()->default(NULL);
          $table->integer('urgency_type')->nullable()->default(NULL); // 1. sangat segera (sekarang),  2. segera, 3.biasa
          $table->integer('status')->nullable()->default(NULL); // pending, read, process, finish, checking, reject, solved
          $table->timestamp('process_at')->nullable()->default(NULL);
          $table->timestamp('finish_at')->nullable()->default(NULL);
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
