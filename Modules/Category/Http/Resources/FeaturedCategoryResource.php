<?php

namespace Modules\Category\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ad\Services\AdTypesService;
use Modules\City\Http\Resources\CityResource;
use Modules\City\Transformers\CityShowResource;

class FeaturedCategoryResource extends JsonResource
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
            'title' => $this->title,
            'type' => $this->type,
            'city' => new CityShowResource($this->city),
            'category' => $this->category,
            'background' => asset($this->formattedUrl),
            'subtypes' => AdTypesService::getAll()[$this->type],
        ];
    }
}