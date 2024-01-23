<?php

namespace Modules\Category\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Category\DataTransferObjects\CategoryAttributeDTO;
use Modules\Category\Entities\Category;
use Modules\Estate\Entities\EstateAttribute;

class CategoriesService
{

    public static function __callStatic($name, $arguments)
    {
        return (new Self)->$name(...$arguments);
    }
    public static function getAll()
    {
        return Cache::rememberForever('categories', function () {
            return Category::select(['id', 'name', 'is_building', 'icon', 'background', 'is_price_per_meter', 'is_bedroom_enable'])->get();
        });
    }
    public static function getAllSimple()
    {
        return Cache::rememberForever('categories_simple', function () {
            return Category::select(['id', 'name'])->get();
        });
    }
    protected function create(CategoryAttributeDTO $categoryAttributeDTO)
    {
        DB::transaction(function () use ($categoryAttributeDTO) {
            $attribute = EstateAttribute::create($categoryAttributeDTO->toArray());
            $categoryAttributeDTO->setAttributeID($attribute->id);
            if ($categoryAttributeDTO->type == 'select' || $categoryAttributeDTO->type == 'radio')
                $attribute->values()->insert($categoryAttributeDTO->getValues());
        });
    }
    protected function update(CategoryAttributeDTO $categoryAttributeDTO, EstateAttribute $attribute)
    {
        DB::transaction(function () use ($categoryAttributeDTO, $attribute) {
            $attribute->update($categoryAttributeDTO->toArray());
            $categoryAttributeDTO->setAttributeID($attribute->id);
            if ($categoryAttributeDTO->type == 'select' || $categoryAttributeDTO->type == 'radio')
                DB::table('estate_attribute_values')->upsert($categoryAttributeDTO->getUpdatedValues($attribute->id), ['id']);
        });
    }
}