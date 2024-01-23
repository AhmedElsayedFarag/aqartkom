<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Auth\Entities\User;
use Modules\Subscription\Entities\Package;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('service_type');
            $table->json('init_data')->nullable();
            $table->json('response_data')->nullable();
            $table->json('inquiry_data')->nullable();
            $table->removeColumn('data');
            $table->unsignedTinyInteger('payment_method')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
