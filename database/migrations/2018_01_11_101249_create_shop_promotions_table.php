<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('shop_promotions', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('shop_id')->unsigned();
          $table->integer('discount');
          $table->integer('get_another');
          $table->integer('flash_sale');

          $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_promotions');
    }
}
