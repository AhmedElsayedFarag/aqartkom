<?php

namespace App\DataTransferObjects;

class MortgageExportDto
{
    public function __construct(
        public ?string $search,
        public ?int $age,
        public ?int $bank,
        public ?int $area,
    ) {
    }
}
