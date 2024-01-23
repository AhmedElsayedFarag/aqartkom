<?php

namespace App\Actions;

use App\DataTransferObjects\AdTypeStatisticsDto;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Entities\Ad;

class GetAdTypeStatistics
{
    /**
     * Handle the action.
     *Get Ads count by type
     *
     * @return AdTypeStatisticsDto
     */
    public function handle(): AdTypeStatisticsDto
    {
        $adTypeCount = Ad::select(['type as ad_type', DB::raw('Count(id) as ads_count')])
            ->status('approved')
            ->groupBy('type')
            ->get()
            ->keyBy('ad_type')
            ->toArray();

        return new AdTypeStatisticsDto(
            $adTypeCount['rent']['ads_count'] ?? 0,
            $adTypeCount['sell']['ads_count'] ?? 0
        );
    }
}