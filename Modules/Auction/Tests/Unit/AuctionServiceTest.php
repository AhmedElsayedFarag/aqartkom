<?php

namespace Modules\Auction\Tests\Unit;

use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Services\AuctionService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\Entities\Estate;
use Modules\Neighborhood\Entities\Neighborhood;
use Tests\TestCase;

class AuctionServiceTest extends TestCase
{
    use DatabaseMigrations;


    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('module:migrate-fresh --seed');
    }

    
    
    public function test_auction_is_updated_with_valid_data()
    {
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

        $this->assertTrue(AuctionService::update($auction, ['initial_price' => 40000]));
    }

    public function test_auction_is_deleted_successfully()
    {
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

        $this->assertTrue(AuctionService::delete($auction));
    }

    public function test_auction_cannot_terminated_if_its_closed()
    {
        try{
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
            
            AuctionService::update($auction, ['is_closed' => 1, 'end_at' => now()]);
            AuctionService::terminate($auction);
        }catch(Exception $e){
            $this->assertSame($e->getCode(), 400);
        }
    }
}
