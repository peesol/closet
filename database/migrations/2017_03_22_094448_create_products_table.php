<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->tinyInteger('shop_type');
            $table->string('uid');
            $table->string('name');
            $table->integer('price');
            $table->integer('discount_price')->nullable();
            $table->dateTime('discount_date')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->integer('view_count')->default(0);
            $table->enum('visibility', ['public','unlisted']);
            $table->boolean('stock')->default(true);
            $table->integer('amount')->default(1);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('category_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
