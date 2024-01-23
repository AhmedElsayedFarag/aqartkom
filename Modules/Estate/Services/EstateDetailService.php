<?php

namespace Modules\Estate\Services;

use Modules\Category\Entities\Category;
use Modules\Estate\DataTransferObject\EstateDetailsDto;
use Modules\Estate\Entities\EstateAttribute;
use Modules\Estate\Entities\EstateDetail;

class EstateDetailService
{

    public function __construct(protected EstateDetailsDto $estateDetailsDto)
    {
    }
    public function create(int $estateID): array
    {
        return $this->estateDetailsDto
            ->format($estateID);
    }
    public static function findMissingAttributes(int $categoryId, $attributes)
    {

        $retrievedAttributes = EstateAttribute::where('category_id', $categoryId)->with([
            'values'
        ])->get()
            ->keyBy('id');
        $missedAttributes = \array_diff($retrievedAttributes->keys()->toArray(), $attributes->keys()->toArray());
        foreach ($missedAttributes as $missedAttribute) {
            $retrievedAttribute = $retrievedAttributes[$missedAttribute];
            $estateDetail = new EstateDetail();

            $estateDetail->estate_attribute_id = $retrievedAttribute->id;
            $estateDetail->attribute = $retrievedAttribute;
            $type = $retrievedAttribute['type'];
            if ($type == 'number' || $type == 'string') {
                $estateDetail->estate_attribute_value_id = null;
                $estateDetail->value = [
                    'type' => $type,
                    'value' => 1,
                ];
            } else {
                $estateDetail->estate_attribute_value_id = $retrievedAttribute->values->first()->id;
                $estateDetail->value = [];
                $estateDetail->attributeValue = $retrievedAttribute->values->first();
            }
            $attributes->push($estateDetail);
        }
        return $attributes;
    }
}