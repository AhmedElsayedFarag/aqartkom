<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CompanyShowResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'company_name' => $this->name ?? "",
            'logo' => Storage::disk('companies')->url($this->logo),
            'description' => $this->description,
            'lat' => (float)$this->lat,
            'long' => (float)$this->long,
            'whatsapp' => $this->whatsapp_number,
            'phone' => $this->user->phone,
            'link' => $this->shareLink,
            'advertisement_number' => $this->commercial_register_number,
            'is_authorized' => (bool) $this->user?->is_authorized,
            'qr_code' => Storage::disk('companies')->url($this->qr_code),
            'is_featured' => (bool) $this->user?->is_featured,
            'ads_count' => $this->user->ads()->count(),
        ];
    }
}
