<?php

namespace App\DataTransferObjects;

class UserCountStatisticsDto
{
    public function __construct(
        public int $customersCount = 0,
        public int $ownersCount = 0,
        public int $marketersCount = 0,
        public int $companiesCount = 0,
    ) {
    }
}