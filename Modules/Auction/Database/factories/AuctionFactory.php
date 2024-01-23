<?php

namespace Modules\Auction\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Estate\Entities\Estate;

class AuctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Auction\Entities\Auction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'initial_price' => fake()->numberBetween(30000, 100000),
            'top_price' => fake()->numberBetween(40000, 1000000),
            'estate_id' => Estate::where('id', '<', 5)->get()->random()->id,
            'end_at' => now()->addMonth(1)
        ];
    }
}