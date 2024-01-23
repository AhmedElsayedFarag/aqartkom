<?php

namespace Modules\Ad\Transformers;

use App\Helpers\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\EstateShowResource;

class AdRequestShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $views = 0;

        return [
            'estate'        => new EstateShowResource($this->estate),
            'id'            => $this->uuid,
            'type'          => $this->type,
            'status'        => $this->formattedStatus,
            // 'views'         => $views,
            'price'         => PriceFormatter::format($this->price),
            'price_of_meters' => $this->price_of_meters > 0 ? PriceFormatter::format($this->price_of_meters) : null,
            'is_dependable' => (bool)$this->is_dependable,
            'is_featured' => (bool)$this->is_featured,
            'is_viewed'     => true,
            'is_favorite' => $this->is_favorite ?? false,
            'accepted_at'   => $this->formattedAcceptedDate,
            'owner_name'    => is_null($this->owner) ? $this->owner_name : \get_owner_name($this->owner),
            'phone'         => is_null($this->owner) ? $this->owner_phone : get_contact_number($this->owner),
            'whatsapp'      => is_null($this->owner) ? $this->owner_phone : \get_whatsapp_number($this->owner),
            'link'          => '#',
            'subtype'       => $this->subtype->name
        ];
    }
}
