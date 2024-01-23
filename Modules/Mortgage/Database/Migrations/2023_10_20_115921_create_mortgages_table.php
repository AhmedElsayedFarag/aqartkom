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
        Schema::create('mortgages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('nationality');
            $table->string('email');
            $table->enum('gender', ['male', 'female']);
            $table->unsignedInteger('age');
            $table->unsignedInteger('bank');
            $table->unsignedInteger('group');
            $table->unsignedInteger('salary');
            $table->unsignedInteger('area');
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
        Schema::dropIfExists('mortgages');
    }
};