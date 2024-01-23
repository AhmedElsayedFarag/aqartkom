<?php

namespace Modules\Category\DataTransferObjects;

class CategoryAttributeDTO
{
    public AttributeValuesDTO $valuesDTO;
    public function __construct(
        public string $type,
        public string $name,
        public ?string $unit = "",
        public int $categoryID,
        array $values = []
    ) {
        if ($type == 'radio')
            $values = ['نعم', 'لا'];
        $this->valuesDTO =  new AttributeValuesDTO($values);
    }
    public function toArray()
    {
        return [
            'name' => $this->name,
            'unit' => $this->unit,
            'category_id' => $this->categoryID,
            'type' => $this->type,
        ];
    }
    public function setAttributeID(int $attributeID)
    {
        $this->valuesDTO->setAttributeID($attributeID);
        return $this;
    }
    public function getValues(): array
    {
        return $this->valuesDTO->formate();
    }
    public function getUpdatedValues(int $attributeID)
    {
        return $this->valuesDTO->formatUpdated($attributeID);
    }
}