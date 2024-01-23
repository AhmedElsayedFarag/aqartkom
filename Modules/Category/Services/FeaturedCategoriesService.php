<?php

namespace Modules\Category\Services;

use Modules\Category\Entities\Category;
use Modules\Category\Entities\FeaturedCategory;

class FeaturedCategoriesService
{
    public static function getAll(int $cityId)
    {
        return FeaturedCategory::select(['id', 'city_id', 'category_id', 'background', 'title', 'type'])
            ->with([
                'city' => fn ($query) => $query->select(['id', 'name', 'lat', 'long']),
                'category' => fn ($query) => $query->select(['id', 'name']),
            ])
            ->where('city_id', $cityId)
            ->get();
    }
}