<?php

namespace Modules\Auction\DataTransferObjects;

use Modules\Auction\Http\Requests\BidStoreRequest;

class BidDto
{
    private string $name;
    private string $phone;
    public int $amount;
    private string $nationalNumber;
    private int $auctionID;
    public function __construct(BidStoreRequest $request)
    {
        $this->name = $request->get('name');
        $this->phone = $request->get('phone');
        $this->amount = $request->get('amount');
        $this->nationalNumber = $request->get('national_number');
    }
    public function setAuctionID(int $auctionID)
    {
        $this->auctionID = $auctionID;
        return $this;
    }
    public function toArray()
    {
        return [
            'name'              => $this->name,
            'phone'             => $this->phone,
            'national_number'   => $this->nationalNumber,
            'amount'            => $this->amount,
            'auction_id'        => $this->auctionID,
            'user_id'           => auth()->id(),
        ];
    }
}