<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowcaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showcase_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('showcase_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();

            $table->foreign('showcase_id')->references('id')->on('showcases')->onDelete('cascade');
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
        Schema::dropIfExists('showcase_products');
    }
}
