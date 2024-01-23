<?php

namespace Modules\Auction\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Auction\Entities\Auction;
use Modules\Auth\Entities\User;

class BidFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Auction\Entities\Bid::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->regexify('^(\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$'),
            'amount' => fake()->numberBetween(40000, 1000000),
            'national_number' => fake()->numerify('##############'),
            'auction_id' => Auction::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}

