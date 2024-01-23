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
        Schema::table('ads', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('is_dependable');
            $table->timestamp('featured_at')->nullable()->after('is_featured');
            $table->timestamp('featured_expires_at')->nullable()->after('featured_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'featured_at', 'featured_expires_at']);
        });
    }
};
