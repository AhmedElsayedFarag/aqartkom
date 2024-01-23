<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ad\Database\Seeders\AdFilterSeederTableSeeder;
use Modules\Auction\Database\Seeders\AuctionDatabaseSeeder;
use Modules\Ad\Database\Seeders\AdsTableSeeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Category\Database\Seeders\FeaturedCategoryDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Estate\Database\Seeders\EstateAttributesSeederTableSeeder;
use Modules\Estate\Database\Seeders\EstateDatabaseSeeder;
use Modules\Neighborhood\Database\Seeders\NeighborhoodDatabaseSeeder;
use Modules\Package\Database\Seeders\PackageDatabaseSeeder;
use Modules\Page\Database\Seeders\PageDatabaseSeeder;
use Modules\Subscription\Database\Seeders\SubscriptionDatabaseSeeder;
use Modules\Role\Database\Seeders\RoleDatabaseSeeder;
use Modules\SEO\Database\Seeders\SEODatabaseSeeder;
use Modules\Setting\Database\Seeders\SettingDatabaseSeeder;
use Modules\Users\Database\Seeders\CompaniesTableSeeder;
use Modules\Users\Database\Seeders\PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleDatabaseSeeder::class);
        $this->call(AuthDatabaseSeeder::class);
        $this->call(PermissionTableSeeder::class);

        $this->call(CityDatabaseSeeder::class);
        $this->call(NeighborhoodDatabaseSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(CategoryDatabaseSeeder::class);
        $this->call(FeaturedCategoryDatabaseSeeder::class);
        $this->call(EstateAttributesSeederTableSeeder::class);
        $this->call(SubscriptionDatabaseSeeder::class);
        $this->call(AuctionDatabaseSeeder::class);
        $this->call(AdsTableSeeder::class);
        $this->call(AdFilterSeederTableSeeder::class);
        $this->call(SettingDatabaseSeeder::class);
        $this->call(PageDatabaseSeeder::class);
        $this->call(PackageDatabaseSeeder::class);
        $this->call(SEODatabaseSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
