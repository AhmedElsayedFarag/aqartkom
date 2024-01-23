<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\City\Entities\City;
use Modules\Neighborhood\Entities\Neighborhood;

uses(Tests\TestCase::class);
test('test_cities_route_return_success', function () {
    $response = $this->getJson('/api/v1/city/59/neighborhood');

    $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', Neighborhood::filterCity(59)->count());
        });
});