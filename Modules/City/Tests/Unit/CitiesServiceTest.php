<?php

use Modules\City\Entities\City;
use Modules\City\Services\CitiesService;

uses(Tests\TestCase::class);
test('test_cities_service_return_all_cities', function () {
    $this->artisan('module:migrate-fresh --seed');
    $this->assertCount(City::all()->count(), CitiesService::getAll()->toArray());
});
