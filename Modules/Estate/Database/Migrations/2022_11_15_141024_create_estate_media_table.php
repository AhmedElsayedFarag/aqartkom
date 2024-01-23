<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_media', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('url');
            $table->enum('type', ['image', 'video']);
            $table->enum('storage_location', ['local', 'remote']);
            $table->foreignId('estate_id')->references('id')->on('estates')->cascadeOnDelete();
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
        Schema::dropIfExists('estate_media');
    }
};