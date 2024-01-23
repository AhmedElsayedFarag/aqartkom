<?php

namespace Modules\Category\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => asset($this->formattedUrl),
            'is_building' => $this->is_building,
            'is_bedroom_enable' => $this->is_bedroom_enable,
            'is_price_per_meter' => $this->is_price_per_meter
        ];
    }
}