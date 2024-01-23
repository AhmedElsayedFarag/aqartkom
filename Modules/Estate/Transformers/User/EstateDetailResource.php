<?php

namespace Modules\Estate\Transformers\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\EstateAttributeValueResource;

class EstateDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'attribute_id' => $this->attribute->id,
            'title' => $this->attribute->name,
            'unit' => $this->attribute->unit,
            'value' => (string)($this->attributeValue?->value ?? $this->value['value']),
            'value_id' => $this->attributeValue?->id,
            'attribute_type'  => $this->attribute->type == 'select' ? 'radio' : $this->attribute->type,
            'value_type' => isset($this->value['value']) ? $this->value['value'] : 'number',
            'values' => EstateAttributeValueResource::collection($this->attribute->values),
        ];
    }
}