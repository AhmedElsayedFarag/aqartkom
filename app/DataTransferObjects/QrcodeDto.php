<?php

namespace App\DataTransferObjects;

class QrcodeDto
{
    public function __construct(
        public string $route,
        public string $disk,
    ) {
    }
}
