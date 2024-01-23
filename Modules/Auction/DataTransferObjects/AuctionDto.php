<?php

namespace Modules\Auction\DataTransferObjects;

class AuctionDto
{

    private int $estateID;
    public function __construct(
        private string $endAt,
        private string $initialPrice,
    ) {
    }
    public function setEstateID(int $estateID)
    {
        $this->estateID = $estateID;
        return $this;
    }
    public function toArray(): array
    {
        return [
            'estate_id' => $this->estateID,
            'initial_price' => $this->initialPrice,
            'top_price' => $this->initialPrice,
            'end_at' => $this->endAt
        ];
    }
}