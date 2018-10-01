<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_products', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('shop_id')->unsigned();
          $table->integer('product_id')->unsigned();
          $table->integer('price');
          $table->integer('discont_price');
          $table->timestamps();

          $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_products');
    }
}
