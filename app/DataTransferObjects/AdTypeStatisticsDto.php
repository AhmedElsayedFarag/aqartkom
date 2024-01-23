<?php

namespace App\DataTransferObjects;

class AdTypeStatisticsDto
{

    public function __construct(
        public int $rentAdsCount = 0,
        public int $sellAdsCount = 0,
    ) {
    }
}