<?php

use Modules\Category\Entities\Category;
use Modules\Category\Services\CategoriesService;


uses(Tests\TestCase::class);
test('test_categories_service_return_all_categories', function () {
    $this->assertCount(Category::all()->count(), CategoriesService::getAll()->toArray());
});