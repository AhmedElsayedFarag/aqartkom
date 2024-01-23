<?php

namespace Modules\Ad\Transformers\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\User\EstateResource;

class AdLicenseShowResource extends JsonResource
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
                'subtype'       => $this->subtype,
                'instrument_number' => $this->instrument_number,
                'advertiser_relation' => $this->advertiser_relation,
                'is_license_request' => (bool) $this->is_license_request,
                'license_number' => $this->license_number,
                'created_at' => $this->created_at,
                'number' => $this->id,
                'license_cost' => $this->license_cost,
                'license_request_status' => is_null($this->license_number) ? 'pending' : 'accepted',
            ];
    }
}
