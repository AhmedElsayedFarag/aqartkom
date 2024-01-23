<?php

namespace Modules\Package\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Package\Services\Api\PackageService;

class PackageResource extends JsonResource
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
            'price' => $this->price,
            'months' => $this->months,
            'features' => PackageService::formatFeatures($this->features),
        ];
    }
}
