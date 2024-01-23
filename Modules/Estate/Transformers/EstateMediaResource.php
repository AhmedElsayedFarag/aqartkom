<?php

namespace Modules\Estate\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EstateMediaResource extends JsonResource
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
            'type' => $this->type,
            'url' => $this->formattedUrl,
        ];
    }
}