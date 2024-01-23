<?php

namespace Modules\Estate\DataTransferObject;

use Illuminate\Support\Facades\DB;

class EstateDetailsDto
{
    private array $estateAttributes = [];
    private array $attributeIDs = [];
    private array $retrievedAttributes = [];
    private array $selectAttributes = [];
    private array $numberAttributes = [];
    private array $stringAttributes = [];

    public function __construct(int $categoryID, array $estateData)
    {
        $this->setRetrievedAttributes($categoryID);
        $this->filter();
        foreach ($estateData as $estateAttribute) {
            $this->addAttribute($estateAttribute);
        }
    }
    private function addAttribute(array $estateAttribute)
    {
        $estateAttributeID = $estateAttribute['attribute'];
        $this->estateAttributes[$estateAttributeID] =
            new EstateAttributeDto(
                $estateAttributeID,
                $estateAttribute['value']
            );
        $this->addAttributeID($estateAttributeID);
    }
    private function addAttributeID(int $attributeID)
    {
        $this->attributeIDs[] = $attributeID;
    }
    public function getIDs(): array
    {
        return $this->attributeIDs;
    }
    public function getSelectAttribute(int $attributeID)
    {
        return $this->selectAttributes[$attributeID];
    }
    public function getValue(int $attributeID): string|int
    {
        return $this->estateAttributes[$attributeID]->value;
    }

    private function setRetrievedAttributes(int $categoryID)
    {
        $this->retrievedAttributes =
            DB::table('estate_attributes')
            ->select(['id', 'type', 'name'])
            ->where('category_id', $categoryID)
            ->get()
            ->keyBy('id')
            ->toArray();
    }
    public function format(int $estateID)
    {
        $formattedDetails = [];
        foreach ($this->estateAttributes as $attributeID => $estateAttribute) {
            $type = $this->retrievedAttributes[$attributeID]->type;
            $isUserDefinedAttribute = $type == 'number' || $type == 'string';
            $attributeValue = $isUserDefinedAttribute ? [
                'value' => $estateAttribute->value,
                'type' => $type,
            ] : [];
            $formattedDetails[] = [
                'estate_id' => $estateID,
                'estate_attribute_id' => $attributeID,
                'type' => !$isUserDefinedAttribute ? "select" : "user_value",
                'estate_attribute_value_id' => $isUserDefinedAttribute ? null : $estateAttribute->value,
                'value' => \json_encode($attributeValue),
            ];
        }
        return $formattedDetails;
    }
    public function getMissingAttributes(): array
    {
        return \array_diff_key($this->retrievedAttributes, \array_flip($this->getIDs()));
    }

    private function filter()
    {
        $this->selectAttributes
            = array_filter($this->retrievedAttributes, fn ($attribute) => $attribute->type == 'select' || $attribute->type == 'radio');
        $inputAttributes = array_diff_key($this->retrievedAttributes, $this->selectAttributes);
        $this->numberAttributes
            = array_filter($inputAttributes, fn ($attribute) => $attribute->type == 'number');
        $this->stringAttributes =
            array_filter($inputAttributes, fn ($attribute) => $attribute->type == 'string');
    }
    public function getNumberAttributes(): array
    {
        return $this->numberAttributes;
    }
    public function getSelectAttributes(): array
    {
        return $this->selectAttributes;
    }
    public function getStringAttributes(): array
    {
        return $this->stringAttributes;
    }
    public function getAttributes(): array
    {
        return $this->retrievedAttributes;
    }
}