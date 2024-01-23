<?php

namespace Modules\Estate\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EstateAttributeValueResource extends JsonResource
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
            'name' => $this->value
        ];
    }
}