<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\FeaturedCategory;

uses(Tests\TestCase::class);
test('test_featured_categories_route_return_success', function () {
    $this->artisan('module:migrate-fresh --seed');
    $response = $this->getJson('/api/v1/featured-category');

    $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', FeaturedCategory::count());
        });
});
