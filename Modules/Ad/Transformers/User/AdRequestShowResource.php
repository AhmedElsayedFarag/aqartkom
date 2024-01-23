<?php

namespace Modules\Ad\Transformers\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\User\EstateResource;

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
        return
            [
                'estate'        => new EstateResource($this->estate),
                'id'            => $this->uuid,
                'type'          => $this->type,
                'status'        => $this->formattedStatus,
                'views'         => $this->views,
                'price'         => $this->price,
                'price_of_meters' => $this->price_of_meters,
                'is_dependable' => (bool)$this->is_dependable,
                'is_featured' => (bool)$this->is_featured,
                'accepted_at'   => $this->formattedAcceptedDate,
                'subtype'       => $this->subtype
            ];
    }
}
