<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentAtToComplaintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaint', function (Blueprint $table) {
            //
            $table->datetime('sent_at')->nullable()->after('status');
            $table->integer('sent_user_id')->nullable()->after('sent_at');
            $table->integer('finish_user_id')->nullable()->after('finish_at');
            $table->datetime('solved_at')->nullable()->after('finish_user_id');
            $table->integer('solved_user_id')->nullable()->after('solved_at');
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
