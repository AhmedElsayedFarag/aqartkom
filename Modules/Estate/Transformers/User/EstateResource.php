<?php

namespace Modules\Estate\Transformers\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\City\Http\Resources\CityResource;
use Modules\Estate\Services\EstateDetailService;

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

        $this->details = EstateDetailService::findMissingAttributes($this->category->id, $this->details->keyBy('estate_attribute_id'));
        return [
            'area'          => $this->area,
            'title'         => $this->title,
            'address'       => $this->address,
            'category'      => $this->category,
            'city'          => new CityResource($this->city),
            'neighborhood'  => !is_null($this->neighborhood) ? [
                'id' => $this->neighborhood->id,
                'name' => $this->neighborhood->name
            ] : null,
            'description'   => $this->description,
            'age'           => $this->age,
            'lat'           => (float)$this->lat,
            'long'          => (float)$this->long,
            'bedroom'       => $this->bedroom,
            'is_furniture'  => $this->is_furniture,
            'media'         => EstateMediaResource::collection($this->media),
            'details'       => EstateDetailResource::collection($this->details),
        ];
    }
}