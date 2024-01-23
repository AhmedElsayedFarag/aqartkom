<?php

namespace Modules\Category\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Http\Requests\CategoryUpdateRequest;
use Modules\City\Http\Requests\CityFilterRequest;
use Modules\Users\Filters\Search;

class CategoriesController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CityFilterRequest $request)
    {
        $categories = app(Pipeline::class)
            ->send(Category::select(['id', 'name']))
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->orderBy('name')
            ->paginate(15);
        return view('category::admin.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('category::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->only(['name', 'is_building', 'is_price_per_meter']);
        $data = [
            ...$data,
            'icon' => upload_image($request->file('icon'), 'categories'),
            'background' => upload_image($request->file('background'), 'categories'),
        ];
        if ($request->get('is_building'))
            $data['is_bedroom_enable'] = $request->get('is_bedroom_enable');
        Category::create($data);
        cache()->forget('categories');
        cache()->forget('categories_simple');
        return \success_add('category.index');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Category $category)
    {
        return view('category::admin.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $data = $request->only(['name', 'is_building']);
        if ($request->has('icon'))
            $data['icon'] = \update_image([
                'oldLink'   => $category->icon,
                'icon'      => $request->file('icon'),
                'disk'      => 'categories'
            ]);
        if ($request->has('background'))
            $data['background'] = \update_image([
                'oldLink'   => $category->background,
                'icon'      => $request->file('background'),
                'disk'      => 'categories'
            ]);
        if ($request->get('is_building'))
            $data['is_bedroom_enable'] = $request->get('is_bedroom_enable');
        $category->update($data);
        cache()->forget('categories');
        cache()->forget('categories_simple');
        if ($category) {
            return \success_update('category.index');
        }
        abort(500);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Category $category)
    {
        if ($category->estates()->count()) {
            session()->flash('danger', __('messages.cannot_be_deleted'));
            return redirect()->back();
        }
        $category->delete();
        cache()->forget('categories');
        cache()->forget('categories_simple');
        return \success_delete('category.index');
    }
}