<?php

namespace App\DataTransferObjects;

class CoordinateDto
{
    public function __construct(
        public float $lat = 21.492500,
        public float $long = 39.177570,
        public string $latName = "lat",
        public string $longName = "long",
    ) {
    }
    public function getLat()
    {
        return $this->lat;
    }
    public function getLong()
    {
        return $this->long;
    }
}