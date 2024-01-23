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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type')->default('fixed'); //fixed, percent
            $table->unsignedInteger('value')->default(0);
            $table->unsignedInteger('max_use')->default(0);
            $table->unsignedInteger('current_usage')->default(0);
            $table->date('expire_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('start_at');
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
        Schema::dropIfExists('coupons');
    }
};
