<?php

namespace Modules\Ad\Transformers\User;

use App\Helpers\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\EstateResource;

class AdsRequestResource extends JsonResource
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

            'id' => $this->uuid,
            'price' => PriceFormatter::format($this->price),
            'type' => $this->type,
            'is_featured' => (bool)$this->is_featured,
            'subtype'       => $this->subtype->name,
            'views' => $this->views,
            'accepted_at' => $this->formattedAcceptedDate,
            'link' => $this->shareLink,
            'estate' => new EstateResource($this->estate),
        ];
    }
}