<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CompaniesResource extends JsonResource
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
            'name' => $this->user?->name ?? $this->name,
            'logo' => Storage::disk('companies')->url($this->logo),
            'is_featured' => (bool) $this->user?->is_featured ?? false,
            'advertisement_number' => $this->commercial_register_number,
            'ads_count' => (int)$this->ads_count,
            'is_authorized' => (bool) $this->user?->is_authorized ?? false,
            'ads_count' => $this->user?->ads()->count() ?? 0,
        ];
    }
}