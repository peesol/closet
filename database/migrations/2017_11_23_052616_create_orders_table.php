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
          $table->char('subtotal', 20);
          $table->char('fee', 20);
          $table->char('total', 20);
          $table->string('discount')->nullable();
          $table->text('shipping')->nullable();
          $table->string('carrier', 30)->nullable();
          $table->string('tracking_number', 40)->nullable();
          $table->text('address')->nullable();
          $table->string('date_paid', 100)->nullable();
          $table->boolean('trans')->default(false);
          $table->boolean('shipped')->default(false);
          $table->boolean('feedback')->default(false);
          $table->tinyInteger('deleted_type')->nullable();

          $table->timestamps();
          $table->softDeletes();

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
