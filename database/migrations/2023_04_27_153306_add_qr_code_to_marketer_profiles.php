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
            $table->string('qr_code')->nullable();
            $table->foreignId('city_id')->nullable()->default(58)->constrained('cities')->onDelete('cascade');
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
            $table->dropColumn('qr_code');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
