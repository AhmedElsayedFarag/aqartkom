<?php

namespace Modules\City\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CityShowResource extends JsonResource
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
            'lat' => (float)$this->lat,
            'long' => (float)$this->long,
        ];
    }
}