<?php


use Modules\Category\Entities\FeaturedCategory;
use Modules\Category\Services\FeaturedCategoriesService;

uses(Tests\TestCase::class);
test('test_featured_categories_service_return_all_featured_categories', function () {
    $this->assertCount(FeaturedCategory::all()->count(), FeaturedCategoriesService::getAll()->toArray());
});