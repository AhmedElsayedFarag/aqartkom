<?php

namespace Modules\Auction\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BidRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Auction\Entities\BidRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}

