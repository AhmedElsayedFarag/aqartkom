<?php

namespace Modules\Estate\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EstateResource extends JsonResource
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
            'area'      => $this->area,
            'title'     => $this->title,
            'address'   => $this->address,
            'bedroom'   => $this->bedroom,
            'category'  => $this->category->name,
            'city'      => $this->city->name,
            'lat'       => (float)$this->lat,
            'long'      => (float)$this->long,
            'media'     => EstateMediaResource::collection($this->images),
            // 'media'     => EstateMediaResource::collection($this->media),
        ];
    }
}
