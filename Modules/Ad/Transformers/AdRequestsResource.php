<?php

namespace Modules\Ad\Transformers;

use App\Helpers\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\EstateMediaResource;
use Modules\Estate\Transformers\EstateResource;

class AdRequestsResource extends JsonResource
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
            'is_dependable' => (bool)$this->is_dependable,
            'is_featured' => (bool)$this->is_featured,
            'price' => PriceFormatter::format($this->price),
            'type' => $this->type,
            // 'views' => $this->views,
            'accepted_at' => $this->formattedAcceptedDate,
            'link' => '#',
            'estate' => new EstateResource($this->estate),
            'owner_name'    => is_null($this->owner) ? $this->owner_name : \get_owner_name($this->owner),
            'phone'         => is_null($this->owner) ? $this->owner_phone : get_contact_number($this->owner),
        ];
    }
}
