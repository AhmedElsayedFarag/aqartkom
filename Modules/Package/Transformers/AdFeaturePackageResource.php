<?php

namespace Modules\Package\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdFeaturePackageResource extends JsonResource
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
            'title' => $this->title,
            'price' => (int)$this->price,
        ];
    }
}
