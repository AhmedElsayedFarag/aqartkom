<?php

namespace App\Actions;

use App\DataTransferObjects\AdStatisticsDto;
use Modules\Ad\Entities\Ad;

class GetAdStatistics
{
    /**
     * Handle the action.
     *Get Ads count by type
     *
     * @return AdStatisticsDto
     */
    public function handle(): AdStatisticsDto
    {
        $licensedAdsCount = Ad::licensed()->count();
        $licensedRequestCount = Ad::licenseRequest()->count();
        $AdMarketingCount = Ad::adMarketing()->count();
        $adsCount = Ad::status('approved')->count(['id']);
        return new AdStatisticsDto(
            $licensedAdsCount,
            $licensedRequestCount,
            $AdMarketingCount,
            $adsCount
        );
    }
}