<?php

namespace Modules\Estate\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Services\EstateService;

class EstateShowResource extends JsonResource
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
            'area'          => $this->area,
            'title'         => $this->title,
            'address'       => $this->address,
            'category'      => $this->category->name,
            'city'          => $this->city->name,
            'description'   => $this->description,
            'age'           => $this->age,
            'lat'           => (float)$this->lat,
            'long'          => (float)$this->long,
            'bedroom'       => $this->bedroom,
            'is_furniture'  => $this->is_furniture,
            'media'         => EstateMediaResource::collection($this->media),
            // 'details'       => EstateDetailResource::collection($this->details),
            'details'       => EstateService::formatDetails($this),
        ];
    }
}