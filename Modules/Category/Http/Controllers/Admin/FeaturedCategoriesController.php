<?php

namespace Modules\Category\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\FeaturedCategory;
use Modules\Category\Http\Requests\FeaturedCategoryRequest;
use Modules\Category\Http\Requests\UpdateFeaturedCategoryRequest;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\CityFilterRequest;
use Modules\Users\Filters\Search;

class FeaturedCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CityFilterRequest $request)
    {
        $categories = app(Pipeline::class)
            ->send(FeaturedCategory::select(['id', 'title', 'city_id', 'category_id'])
                ->with(['city:name,id', 'category:name,id']))
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->orderBy('title')
            ->paginate(15);
        return view('category::featured_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();
        $cities = City::select(['id', 'name'])->get();
        return view('category::featured_categories.create', compact('categories', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FeaturedCategoryRequest $request)
    {
        $data = $request->only(['title', 'city_id', 'category_id', 'type']);
        $data = [
            ...$data,
            'background' => upload_image($request->file('background'), 'categories'),
        ];
        FeaturedCategory::create($data);
        return \success_add('featured-category.index');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(FeaturedCategory $category)
    {
        $categories = Category::select(['id', 'name'])->get();
        $cities = City::select(['id', 'name'])->get();
        return view('category::featured_categories.edit', compact('category', 'categories', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateFeaturedCategoryRequest $request, FeaturedCategory $category)
    {
        $data = $request->only(['title', 'city_id', 'category_id', 'type']);
        if ($request->has('background'))
            $data['background'] = \update_image([
                'oldLink'   => $category->background,
                'icon'      => $request->file('background'),
                'disk'      => 'categories'
            ]);
        $category->update($data);
        if ($category) {
            return \success_update('featured-category.index');
        }
        abort(500);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(FeaturedCategory $category)
    {
        $category->delete();
        return \success_delete('featured-category.index');
    }
}
