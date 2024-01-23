<?php

namespace Modules\Estate\DataTransferObject;

use App\Helpers\Geohash;

class EstateDto
{
    private EstateDetailsDto $estateDetailsDto;
    public function __construct(
        public array $estate,
        public array $details = [],
        public array $media,
        public array $deletedMedia = [],
    ) {
        $this->estateDetailsDto = new EstateDetailsDto($this->getCategory(), $this->details);
        $this->estate['geo_hash'] = Geohash::encode($this->estate['lat'], $this->estate['long'], 12);
    }
    public function toArray()
    {
        return  [
            'estate' => $this->estate,
            'details' => $this->details,
            'media' => $this->media,
        ];
    }
    public function getCategory(): int
    {
        return $this->estate['category'];
    }
    public function getEstateDetails(): EstateDetailsDto
    {
        return $this->estateDetailsDto;
    }
}