<?php

namespace Modules\Estate\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EstateAttributeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type == 'select' ? 'radio' : $this->type,
            'unit' => $this->unit,
            'values' => EstateAttributeValueResource::collection($this->values),
        ];
    }
}