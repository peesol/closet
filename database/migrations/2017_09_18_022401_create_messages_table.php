<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned();
            $table->integer('reciever_id')->unsigned();
            $table->string('sender');
            $table->string('reciever');
            $table->enum('type', ['message', 'order', 'trans']);
            $table->string('title');
            $table->text('body');
            $table->string('total', 16);
            $table->boolean('read')->default(false);
            $table->boolean('confirmed')->default(false);
            $table->boolean('trans')->default(false);

            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reciever_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
