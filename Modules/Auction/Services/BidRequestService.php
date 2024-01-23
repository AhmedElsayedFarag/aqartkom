<?php

namespace Modules\Auction\Services;

use Illuminate\Support\Facades\DB;
use Modules\Auction\Entities\Bid;
use Modules\Auction\Entities\BidRequest;

class BidRequestsService
{
    public function updateStatus(int $bidRequestID, string $status)
    {
        DB::table('bid_requests')->where('id', $bidRequestID)->update(['status' => $status]);
    }
    public function accept(BidRequest $bidRequest)
    {
        DB::transaction(function () use ($bidRequest) {
            $bidRequest->load([
                'auction' => fn ($query) => $query->select(['id', 'estate_id', 'end_at', 'is_closed', 'top_price']),
                'auction.estate' => fn ($query) => $query->select(['id', 'area']),
                'user' => fn ($query) => $query->select(['id', 'mobile_token']),
            ]);
            //check is closed or not
            if (!AuctionService::inProcess($bidRequest->auction)) {
                $this->updateStatus($bidRequest->id, 'closed');
                //push notification
            }
            AuctionService::checkIfClosed($bidRequest->auction);

            $this->updateStatus($bidRequest->id, 'approved');
            $amount = $bidRequest->amount;
            $total = $amount * $bidRequest->auction->estate->area;
            Bid::create([
                'user_id' => $bidRequest->user_id,
                'auction_id' => $bidRequest->auction_id,
                'amount' => $amount,
                'total' => $total,
            ]);
            //push notification
            if ($amount > $bidRequest->auction->top_price)
                $bidRequest->auction->update(['top_price' => $amount]);
        });


        //change status
        //create bid
        //push notification
    }
}