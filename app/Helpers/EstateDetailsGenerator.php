<?php

namespace App\Helpers;

use Modules\Category\Entities\Category;

trait EstateDetailsGenerator
{
    public function generateDetails(int $estateID, Category $category)
    {
        return $category->attributes->map(function ($attribute) use ($estateID) {
            $value = null;
            $type = $attribute->type;
            if ($type == 'select' || $type == 'radio') {
                $value = $attribute->values->random()->id;
            } else if ($type == 'number') {
                $value = rand(1, 10);
            } else {
                $value = 'test';
            }

            $isUserDefinedAttribute = $type == 'number' || $type == 'string';
            $attributeValue = $isUserDefinedAttribute ? [
                'value' => $value,
                'type' => $type,
            ] : [];
            return  [
                'estate_id' => $estateID,
                'estate_attribute_id' => $attribute->id,
                'type' => !$isUserDefinedAttribute ? "select" : "user_value",
                'estate_attribute_value_id' => $isUserDefinedAttribute ? null : $value,
                'value' => \json_encode($attributeValue),
            ];
        })->toArray();
    }
}
