<?php

namespace Modules\Auth\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MarketersResource extends JsonResource
{
    public static $wrap = null;

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
            'name' => $this->name,
            'phone' => $this->phone,
            'profile' => $this->formattedProfile,
            'ads_count' => (int)$this->ads_count,
            'whatsapp_number' => $this->marketerProfile->whatsapp_number ?? $this->phone,
            'advertisement_number' => $this->marketerProfile->advertisement_number,
            'qr_code' => Storage::disk('marketers')->url($this->marketerProfile->qr_code),
            'is_featured' => (bool) $this->is_featured
        ];
    }
}