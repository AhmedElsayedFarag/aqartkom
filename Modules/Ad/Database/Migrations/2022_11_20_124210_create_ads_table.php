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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('estate_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['sell', 'rent']);
            $table->enum('status', ['pending', 'approved', 'cancelled', 'closed'])->default('pending');
            $table->unsignedBigInteger('views')->default(0);
            $table->string('price');
            $table->boolean('is_dependable')->default(false);
            $table->dateTime('accepted_at')->nullable();
            $table->unique(['user_id', 'estate_id']);
            $table->string('owner_name');
            $table->string('owner_phone');
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
        Schema::dropIfExists('ads');
    }
};