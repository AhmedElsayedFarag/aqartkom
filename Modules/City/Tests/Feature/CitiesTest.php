<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\City\Entities\City;

uses(Tests\TestCase::class);
test('test_cities_route_return_success', function () {
    $this->artisan('module:migrate-fresh --seed');
    $response = $this->getJson('/api/v1/city');

    $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', City::count());
        });
});
