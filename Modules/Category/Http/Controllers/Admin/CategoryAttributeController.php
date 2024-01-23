<?php

namespace Modules\Category\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\DataTransferObjects\CategoryAttributeDTO;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryAttributeRequest;
use Modules\Category\Services\CategoriesService;
use Modules\Estate\Entities\EstateAttribute;

class CategoryAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Category $category)
    {
        $category->load([
            'attributes' => fn ($query) => $query->select(['id', 'category_id', 'name', 'type']),
            'attributes.values' => fn ($query) => $query->select(['id', 'estate_attribute_id', 'value'])
        ]);
        $attributes = $category->attributes;
        return view('category::attributes.index', compact('attributes', 'category'));
    }

    public function create(Category $category)
    {
        return view('category::attributes.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CategoryAttributeRequest $request, Category $category)
    {
        $categoryAttributeDto = new CategoryAttributeDTO(
            $request->get('type'),
            $request->get('name'),
            $request->get('unit'),
            $category->id,
            $request->get('values') ?? [],
        );
        CategoriesService::create($categoryAttributeDto);
        return \success_add('attribute.index', ['category' => $category->id]);
    }
    public function edit(Category $category, EstateAttribute $attribute)
    {
        return view('category::attributes.edit', compact('category', 'attribute'));
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function update(CategoryAttributeRequest $request, Category $category, EstateAttribute $attribute)
    {
        $categoryAttributeDto = new CategoryAttributeDTO(
            $request->get('type'),
            $request->get('name'),
            $request->get('unit'),
            $category->id,
            $request->get('values') ?? [],
        );
        CategoriesService::update($categoryAttributeDto, $attribute);
        return \success_update('attribute.index', ['category' => $category->id]);
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Category $category, EstateAttribute $attribute)
    {
        $attribute->delete();
        return \success_delete('attribute.index', ['category' => $category->id]);
    }
}