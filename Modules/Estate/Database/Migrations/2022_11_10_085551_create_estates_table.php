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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address');
            $table->text('description');
            $table->unsignedBigInteger('area');
            $table->foreignId('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreignId('city_id')->references('id')->on('cities')->cascadeOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->references('id')->on('neighborhoods')->cascadeOnDelete();
            $table->unsignedInteger('age')->nullable();
            $table->unsignedInteger('bedroom')->nullable();
            $table->boolean('is_building')->default(false);
            $table->boolean('is_furniture')->default(false);
            $table->decimal('lat', 10, 7)->index();
            $table->decimal('long', 10, 7)->index();
            $table->enum('type', ['ad', 'auction']);
            // $table->morphs('estatable');
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
        Schema::dropIfExists('estates');
    }
};