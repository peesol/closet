<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_products', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('category_id')->unsigned();
          $table->integer('subcategory_id')->unsigned();
          $table->integer('type_id')->unsigned();
          $table->string('uid');
          $table->string('name');
          $table->integer('price');
          $table->integer('discount_price')->nullable();
          $table->text('description')->nullable();
          $table->string('thumbnail');
          $table->integer('view_count')->default(0);
          $table->boolean('stock')->default(true);
          $table->integer('amount')->default(1);
          $table->string('shipping')->nullable();
          $table->integer('shipping_time')->nullable();
          $table->boolean('shipping_free')->default(true);
          $table->integer('shipping_fee')->nullable();
          $table->enum('shipping_inter', ['yes','no','contact'])->default('no');
          $table->timestamps();

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
        Schema::dropIfExists('featured_products');
    }
}
