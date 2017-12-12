<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('used_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->string('uid');
            $table->string('name');
            $table->integer('price');
            $table->text('description')->nullable();
            $table->string('thumbnail');

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('category_types')->onDelete('cascade');
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
        Schema::dropIfExists('used_products');
    }
}
