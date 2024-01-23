<?php

namespace Modules\Category\DataTransferObjects;

use Illuminate\Support\Facades\DB;

class AttributeValuesDTO
{
    private int $attributeID;
    public function __construct(
        private array $values
    ) {
    }
    public function setAttributeID(int $attributeID)
    {
        $this->attributeID = $attributeID;
    }
    public function formate(): array
    {
        $formattedValues = [];
        foreach ($this->values as $value) {
            $formattedValues[] = [
                'estate_attribute_id' => $this->attributeID,
                'value' => $value,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];
        }
        return $formattedValues;
    }
    public function formatUpdated(int $attributeID)
    {
        $ids = DB::table('estate_attribute_values')
            ->select(['id'])
            ->where('estate_attribute_id', $attributeID)
            ->get()
            ->pluck('id')
            ->toArray();
        $formattedValues = [];
        foreach ($this->values as $key => $value) {
            $formattedValues[] = [
                'estate_attribute_id' => $this->attributeID,
                'value' => $value,
                'id' => isset($ids[$key]) ? $ids[$key] : 0,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];
        }
        return $formattedValues;
    }
}
