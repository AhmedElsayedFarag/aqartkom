<?php

namespace Modules\Auction\Database\Seeders;

use App\Helpers\EstateDetailsGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\Bid;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Entities\EstateDetail;
use Modules\Estate\Entities\EstateMedia;
use Modules\Estate\Services\EstateService;
use Modules\Neighborhood\Entities\Neighborhood;
use Illuminate\Support\Str;

class AuctionDatabaseSeeder extends Seeder
{
    use EstateDetailsGenerator;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estates')->insert(
            [
                [
                    'title' => 'NEW ESTATE',
                    'description' => 'NEW ESTATE DESCRIPTION',
                    'area' => '1231',
                    'category_id' => Category::all()->random()->id,
                    'city_id' => City::all()->random()->id,
                    'neighborhood_id' => Neighborhood::all()->random()->id,
                    'address' => 'test address',
                    'age' => '3',
                    'bedroom' => '5',
                    'is_building' => true,
                    'is_furniture' => false,
                    'lat' => 1.3231,
                    'long' => 1.4414,
                    'type' => 'auction'
                ],
                [
                    'title' => 'NEW ESTATE',
                    'description' => 'NEW ESTATE DESCRIPTION',
                    'area' => '1231',
                    'category_id' => Category::all()->random()->id,
                    'city_id' => City::all()->random()->id,
                    'neighborhood_id' => Neighborhood::all()->random()->id,
                    'address' => 'test address',
                    'age' => '3',
                    'bedroom' => '5',
                    'is_building' => true,
                    'is_furniture' => false,
                    'lat' => 1.3231,
                    'long' => 1.4414,
                    'type' => 'auction'
                ],
                [
                    'title' => 'NEW ESTATE',
                    'description' => 'NEW ESTATE DESCRIPTION',
                    'area' => '1231',
                    'category_id' => Category::all()->random()->id,
                    'city_id' => City::all()->random()->id,
                    'neighborhood_id' => Neighborhood::all()->random()->id,
                    'address' => 'test address',
                    'age' => '3',
                    'bedroom' => '5',
                    'is_building' => true,
                    'is_furniture' => false,
                    'lat' => 1.3231,
                    'long' => 1.4414,
                    'type' => 'auction'
                ],
                [
                    'title' => 'NEW ESTATE',
                    'description' => 'NEW ESTATE DESCRIPTION',
                    'area' => '1231',
                    'category_id' => Category::all()->random()->id,
                    'city_id' => City::all()->random()->id,
                    'neighborhood_id' => Neighborhood::all()->random()->id,
                    'address' => 'test address',
                    'age' => '3',
                    'bedroom' => '5',
                    'is_building' => true,
                    'is_furniture' => false,
                    'lat' => 1.3231,
                    'long' => 1.4414,
                    'type' => 'auction'
                ]
            ]
        );
        Auction::insert([
            [
                'uuid' => Str::uuid(),
                'initial_price' => fake()->numberBetween(30000, 100000),
                'top_price' => fake()->numberBetween(40000, 1000000),
                'estate_id' => 1,
                'is_closed' => 0,
                'end_at' => now()->addMonth(1)
            ],
            [
                'uuid' => Str::uuid(),
                'initial_price' => fake()->numberBetween(30000, 100000),
                'top_price' => fake()->numberBetween(40000, 1000000),
                'estate_id' => 2,
                'is_closed' => 0,
                'end_at' => now()->addMonth(1)
            ],
            [
                'uuid' => Str::uuid(),
                'initial_price' => fake()->numberBetween(30000, 100000),
                'top_price' => fake()->numberBetween(40000, 1000000),
                'estate_id' => 3,
                'is_closed' => 1,
                'end_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'initial_price' => fake()->numberBetween(30000, 100000),
                'top_price' => fake()->numberBetween(40000, 1000000),
                'estate_id' => 4,
                'is_closed' => 1,
                'end_at' => now()
            ],
        ]);
        //Bid::factory(10)->create();
        $estateIDs = Auction::select(['estate_id'])->get()->pluck('estate_id')->toArray();
        $estateService = new EstateService();
        $media = [];
        $details = [];
        $category = Category::first();
        foreach ($estateIDs as $estateID) {
            $media = [
                ...$media,
                ...$estateService->generateMedia($estateID),
            ];
            $details = [
                ...$details,
                ...$this->generateDetails($estateID, $category),
            ];
        }

        EstateMedia::insert($media);
        EstateDetail::insert($details);
        // Bid::factory(10)->create();
    }
}