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
        Schema::create('share_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('notes_id');
            $table->integer('share_id');
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('notes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('share_id')->references('id')->on('share_data')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_notes');
    }
};
