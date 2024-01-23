<?php

namespace Modules\Auction\Tests\Unit;

use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Auction\Services\AuctionService;
use Modules\Auth\Entities\User;
use Modules\Auction\Services\BidService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\Entities\Estate;
use Modules\Neighborhood\Entities\Neighborhood;
use Tests\TestCase;

class BidServiceTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('module:migrate-fresh --seed');
    }

    public function test_new_bid_cannot_be_created_if_auction_is_not_in_process()
    {
        try {
            $category = Category::create([
                'name' => 'CATEGORY NAME',
                'icon' => 'ICON',
                'is_building' => true
            ]);

            $city = City::create(['name' => 'CITY']);

            $neighborhood = Neighborhood::create([
                'city_id' => $city->id,
                'name' => 'Neighborhood'
            ]);

            $estate = Estate::create([
                'title' => 'NEW ESTATE',
                'description' => 'NEW ESTATE DESCRIPTION',
                'area' => '1231',
                'category_id' => $category->id,
                'city_id' => $city->id,
                'neighborhood_id' => $neighborhood->id,
                'address' => 'test address',
                'age' => '3',
                'bedroom' => '5',
                'is_building' => true,
                'is_furniture' => false,
                'lat' => 1.3231,
                'long' => 1.4414,
            ]);

            $auction = AuctionService::create($estate, [
                'initial_price' => 30000,
            ]);

            $user = User::factory()->create();

            BidService::newBid($auction, $user, [
                'phone' => '+966541515113',
                'name' => 'TEST USER',
                'amount' => 60000,
                'national_number' => '1241241241242',
                'user_id' => $user->id,
                'auction_id' => $auction->id
            ]);
        } catch (Exception $e) {
            $this->assertSame($e->getCode(), 400);
        }
    }

    public function test_new_bid_cannot_be_created_if_amount_is_not_enough()
    {
        try {

            $category = Category::create([
                'name' => 'CATEGORY NAME',
                'icon' => 'ICON',
                'is_building' => true
            ]);

            $city = City::create(['name' => 'CITY']);

            $neighborhood = Neighborhood::create([
                'city_id' => $city->id,
                'name' => 'Neighborhood'
            ]);

            $estate = Estate::create([
                'title' => 'NEW ESTATE',
                'description' => 'NEW ESTATE DESCRIPTION',
                'area' => '1231',
                'category_id' => $category->id,
                'city_id' => $city->id,
                'neighborhood_id' => $neighborhood->id,
                'address' => 'test address',
                'age' => '3',
                'bedroom' => '5',
                'is_building' => true,
                'is_furniture' => false,
                'lat' => 1.3231,
                'long' => 1.4414,
            ]);

            $auction = AuctionService::create($estate, [
                'initial_price' => 30000,
            ]);

            $user = User::factory()->create();

            BidService::newBid($auction, $user, [
                'phone' => '+966541515113',
                'name' => 'TEST USER',
                'amount' => 60000,
                'national_number' => '1241241241242',
                'user_id' => $user->id,
                'auction_id' => $auction->id
            ]);

            BidService::newBid($auction, $user, [
                'phone' => '+966541512113',
                'name' => 'TEST USER',
                'amount' => 50000,
                'national_number' => '1241241241642',
                'user_id' => $user->id,
                'auction_id' => $auction->id
            ]);
        } catch (Exception $e) {
            $this->assertSame($e->getCode(), 400);
        }
    }
}
