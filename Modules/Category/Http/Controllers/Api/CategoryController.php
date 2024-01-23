<?php

namespace Modules\Category\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Category\Services\CategoriesService;
use Modules\Estate\Transformers\EstateAttributeResource;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(CategoriesService::getAll());
    }
    public function attributes(Category $category)
    {
        $category->load([
            'attributes',
            'attributes.values',
        ]);
        return EstateAttributeResource::collection($category->attributes);
    }
}