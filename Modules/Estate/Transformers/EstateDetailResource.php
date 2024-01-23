<?php

namespace Modules\Estate\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'title' => $this->attribute->name,
            'value' => $this->attributeValue?->value ?? $this->value['value'] . ""
        ];
    }
}