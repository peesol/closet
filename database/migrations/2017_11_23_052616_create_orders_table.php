<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('sender_id')->unsigned();
          $table->integer('reciever_id')->unsigned();
          $table->string('sender');
          $table->string('reciever');
          $table->string('uid');
          $table->string('title');
          $table->text('body');
          $table->integer('total');
          $table->boolean('free_shipping')->nullable();
          $table->integer('shipping_fee')->nullable();
          $table->boolean('confirmed')->default(false);
          $table->boolean('trans')->default(false);
          $table->boolean('shipped')->default(false);

          $table->timestamps();

          $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
          $table->foreign('reciever_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
