<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_sender_id');
            $table->integer('user_receiver_id');
            $table->timestamps();

            $table->foreign('user_sender_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_receiver_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_data');
    }
};
