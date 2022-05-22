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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->date('action_date');
            $table->integer('user_id');
            $table->integer('data_id');
            $table->integer('type_table_id');
            $table->integer('type_action_id');

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_action_id')->references('id')->on('type_actions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_table_id')->references('id')->on('type_table')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
};
