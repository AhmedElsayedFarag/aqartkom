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
        Schema::create('estate_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_id')->references('id')->on('estates')->cascadeOnDelete();
            $table->foreignId('estate_attribute_id')->references('id')->on('estate_attributes')->cascadeOnDelete();
            $table->enum('type', ['select', 'user_value']);
            $table->foreignId('estate_attribute_value_id')->nullable()->references('id')->on('estate_attribute_values')->cascadeOnDelete();
            $table->json('value'); //{value:"",type:""} type=>number , string
            $table->unique(['estate_id', 'estate_attribute_id'], 'estate_unique');
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
        Schema::dropIfExists('estate_details');
    }
};