<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUriColumnToLogActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_activity', function (Blueprint $table) {
            //
            $table->string('uri')->nullable()->default(null)->after('browser');
            $table->text('response')->nullable()->default(null)->after('uri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_activity', function (Blueprint $table) {
            //
        });
    }
}
