<?php

namespace Modules\Ad\Traits;

use Modules\Ad\Entities\Ad;

trait BaseUserAdQuery
{
    public function baseUserAdQuery()
    {
        return
            Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'is_dependable', 'is_featured', 'status', 'ad_type_id', 'instrument_number', 'advertiser_relation', 'is_license_request', 'license_number', 'is_licensed'])
            ->join('estates', 'estates.id', '=', 'ads.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                'estate.media' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                'estate.category' => fn ($query) => $query->select(['id', 'name']),
                'estate.city' => fn ($query) => $query->select(['id', 'name']),
                'subtype:id,name'
            ]);
    }
}