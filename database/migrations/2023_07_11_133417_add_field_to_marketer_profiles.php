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
        Schema::table('marketer_profiles', function (Blueprint $table) {
            $table->enum('advertisement_type', ['mediator', 'advertiser', 'marketer'])->default('marketer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marketer_profiles', function (Blueprint $table) {
            //
        });
    }
};
