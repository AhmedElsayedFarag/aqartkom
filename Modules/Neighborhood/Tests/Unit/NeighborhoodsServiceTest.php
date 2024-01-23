<?php

use Modules\City\Entities\City;
use Modules\City\Services\CitiesService;
use Modules\Neighborhood\Entities\Neighborhood;
use Modules\Neighborhood\Services\NeighborhoodsService;

uses(Tests\TestCase::class);
test('test_neighborhoods_service_return_all_neighborhoods', function () {
    $city = City::select(['id'])->where('name', "الرياض")->first()->id;
    $this->assertCount(Neighborhood::filterCity($city)->count(), NeighborhoodsService::getAll($city)->toArray());
});