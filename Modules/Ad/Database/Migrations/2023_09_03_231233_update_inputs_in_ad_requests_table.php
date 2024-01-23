<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_requests', function (Blueprint $table) {
            $table->dropForeign('ad_requests_category_id_foreign');
            $table->dropForeign('ad_requests_city_id_foreign');
            $table->dropColumn(['name' , 'phone' , 'category_id' , 'city_id' , 'units_number' , 'notes']);
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
            $table->unsignedBigInteger('price_of_meters')->nullable();
            $table->foreignId('ad_type_id')->nullable()->constrained('ad_types')->onDelete('set null');
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
        Schema::table('ad_requests', function (Blueprint $table) {

        });
    }
};
