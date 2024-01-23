<?php

namespace Modules\Subscription\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Subscription\Services\SubscriptionService;

class SubscriptionShowResource extends JsonResource
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
            'title' => $this->package_name,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'features' => SubscriptionService::formatFeatures($this->features),
            'is_subscribed' => true
        ];
    }
}
