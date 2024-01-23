<?php

namespace Modules\City\Services;

use Illuminate\Support\Facades\DB;
use Modules\Ad\Entities\Ad;
use Modules\City\Entities\City;

class CitiesService
{
    public static function getAll()
    {

        return City::select(['cities.id', 'name', 'cities.lat', 'cities.long'])
            ->withCount([
                'estates as ads_count' => function ($query) {
                    $query->join('ads', 'ads.estate_id', '=', 'estates.id')
                        ->where('ads.status', 'approved');
                }
            ])
            ->orderBy('priority')
            ->get();
    }
}