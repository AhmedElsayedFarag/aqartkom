<?php

namespace Modules\Ad\Transformers;

use App\Helpers\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\EstateMediaResource;
use Modules\Estate\Transformers\EstateResource;

class AdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // is_request
        $data = [
            'id' => $this->uuid,
            'is_dependable' => (bool)$this->is_dependable,
            'is_featured' => (bool)$this->is_featured,
            'price' => PriceFormatter::format($this->price),
            'type' => $this->type,
            'type_text' => __('admin.ad_type')[$this->type->value],
            'views' => $this->views,
            'accepted_at' => $this->formattedAcceptedDate,
            'link' => $this->shareLink,
            'is_marketing_request' => $this->is_request,
            'estate' => new EstateResource($this->estate),
            'meter_price' => ceil($this->price / $this->estate->area),
            'is_licensed' => (bool)$this->is_licensed,
        ];
        if ($this->is_request) {
            $data = \array_merge($data, [
                'owner_name'    => '',
                'phone'         => '',
            ]);
        } else {
            $data = \array_merge($data, [
                'owner_name'    => is_null($this->owner) ? $this->owner_name : \get_owner_name($this->owner),
                'phone'         => is_null($this->owner) ? $this->owner_phone : get_contact_number($this->owner),
            ]);
        }
        return $data;
    }
}