<?php

namespace App\DataTransferObjects;

class AdStatisticsDto
{
    public function __construct(
        public int $licensedAdsCount = 0,
        public int $licensedRequestCount = 0,
        public int $adMarketingCount = 0,
        public int $adsCount = 0,
    ) {
    }
}