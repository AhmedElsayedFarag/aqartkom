<?php

namespace Modules\Category\Http\Controllers\Api;


use Illuminate\Routing\Controller;
use Modules\Category\Http\Resources\FeaturedCategoryResource;
use Modules\Category\Services\FeaturedCategoriesService;

class FeaturedCategoryController extends Controller
{
    public function __invoke()
    {
        return FeaturedCategoryResource::collection(FeaturedCategoriesService::getAll(58));
    }
}