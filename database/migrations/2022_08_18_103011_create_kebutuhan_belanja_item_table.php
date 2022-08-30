<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKebutuhanBelanjaItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kebutuhan_belanja_item', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('kebutuhan_belanja_id')->nullable()->default(null);
          $table->integer('product_id')->nullable()->default(null);
          $table->string('vol')->nullable()->default(null);
          $table->integer('satuan_id')->nullable()->default(null);
          $table->decimal('harga_satuan',16,2)->nullable()->default(null);
          $table->decimal('jumlah',16,2)->nullable()->default(null);
          $table->string('ket')->nullable()->default(null);
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
        Schema::dropIfExists('kebutuhan_belanja_item');
    }
}
