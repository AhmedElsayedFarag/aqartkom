<?php

namespace Modules\Neighborhood\Services;

use Illuminate\Support\Facades\DB;
use Modules\Neighborhood\Entities\Neighborhood;

class NeighborhoodsService
{
    public static function getAll(int $cityId)
    {
        return Neighborhood::select(['id', 'name'])
            ->filterCity($cityId)
            ->withCount('estates as ads_count')
            ->get();
        // return Neighborhood::select(['id', 'name'])
        //     ->filterCity($cityId)
        //     ->get();
    }
}