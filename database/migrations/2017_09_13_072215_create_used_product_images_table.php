<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsedProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('used_product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();          
            $table->string('filename');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('used_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('used_product_images');
    }
}
