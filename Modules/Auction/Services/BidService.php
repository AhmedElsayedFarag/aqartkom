<?php

namespace Modules\Auction\Services;

use App\DataTransferObjects\FCMDTO;
use App\Helpers\FCMHelper;
use App\Notifications\BidRequestIsAcceptedNotification;
use App\Notifications\BidRequestIsCancelledNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Auction\DataTransferObjects\BidDto;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\Bid;
use Modules\Auction\Entities\BidRequest;
use Modules\Auction\Enums\BidRequestStatusEnum;
use Modules\Auction\Exceptions\AuctionIsClosedException;
use Modules\Auction\Exceptions\BidIsNotEnoughException;
use Modules\Auction\Exceptions\BidIsPendingException;
use Modules\Auction\Services\AuctionService;
use Modules\Auth\Entities\User;
use Symfony\Component\HttpFoundation\Response;

class BidService
{
    /**
     * Get all bids on auction.
     *

     */
    public static function getAll()
    {
        return Bid::select([
            'id', 'phone',
            'national_number',
            'status',
            'auction_id',
            'name'
        ])
            ->with([
                'auction' => fn ($query) => $query->select(['id', 'estate_id']),
                'auction.estate' => fn ($query) => $query->select(['id', 'title']),
            ])
            ->status('pending')
            ->paginate();
    }

    /**
     * Get all user bids on auction.
     *
     * @param  \Modules\Auction\Entities\Auction  $auction
     * @param  \Modules\Auth\Entities\User  $user
     * @return \Modules\Auction\Entities\Auction
     */
    public  function getUserBidRequests(int $userID, string $status)
    {
        return Bid::select(['auction_id', 'id', 'amount'])
            ->userFilter($userID)
            ->status($status)
            ->with([
                'auction' => fn ($query) => $query->select(['id', 'estate_id', 'initial_price', 'top_price', 'is_closed', 'end_at', 'uuid']),
                'auction.estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long']),
                'auction.estate.media' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                'auction.estate.category' => fn ($query) => $query->select(['id', 'name']),
                'auction.estate.city' => fn ($query) => $query->select(['id', 'name']),
            ])
            ->paginate(15);
    }

    public function createOrUpdate(Auction $auction, BidDto $bidDto)
    {
        AuctionService::checkIfClosed($auction);
        $bid = $this->getUserBid($auction->id);
        $this->loadArea($auction);
        $total = $bidDto->amount * $auction->estate->area;
        if (is_null($bid)) {
            return Bid::create([
                ...$bidDto->setAuctionID($auction->id)->toArray(),
                'total' => $total,
            ]);
        }
        $this->isPending($bid);
        $this->isEnoughAmount($auction, $bidDto->amount);
        $bid->update([
            'amount' => $bidDto->amount,
            'total' => $total,
        ]);
        $this->updateAuctionTopPrice($auction, $bidDto->amount);
        return $bid;
    }
    public function isEnoughAmount(Auction $auction, int $bidAmount)
    {
        if (!$this->isHigh($auction, $bidAmount))
            throw new BidIsNotEnoughException();
    }
    public function isPending(Bid $bid)
    {
        if ($bid->status == 'pending') {
            throw new BidIsPendingException();
        }
    }
    public function getUserBid(int $auctionID): ?Bid
    {
        return Bid::select(['id', 'status'])->where('user_id', auth()->id())
            ->firstWhere('auction_id', $auctionID);
    }
    public function isHigh(Auction $auction, int $bidAmount)
    {
        return $auction->top_price < $bidAmount;
    }
    public function accept(Bid $bid)
    {
        DB::transaction(function () use ($bid) {
            $bid->load(['auction' => fn ($query) => $query->select(['id', 'top_price', 'estate_id', 'end_at', 'is_closed', 'uuid'])]);
            $this->loadArea($bid->auction);
            if ($this->isHigh($bid->auction, $bid->amount))
                $this->updateAuctionTopPrice($bid->auction, $bid->amount);
            $this->updateStatus($bid, "approved");
            $bid->user->notify(new BidRequestIsAcceptedNotification($bid->user->mobile_token));
        });
    }
    public function cancel(Bid $bid)
    {
        if ($bid->status == 'pending') {
            $this->updateStatus($bid, 'declined');
            $bid->user->notify(new BidRequestIsCancelledNotification($bid->user->mobile_token));
        }
    }
    public function loadArea(Auction &$auction)
    {
        $auction->load(['estate' => fn ($query) => $query->select(['id', 'area'])]);
    }
    public function updateAuctionTopPrice(Auction $auction, int $amount)
    {
        $dto = new FCMDTO(
            title: __('messages.auction_price_is_updated_title'),
            body: __('messages.auction_price_is_updated_body', ['title' => $auction->estate->title, 'price' => $amount]),
            topic: 'auction'
        );
        $dto->isHidden()
            ->setType('auction')
            ->addData('auction', $auction->uuid)
            ->addData('price', $amount);

        FCMHelper::sendTopic($dto);
        $auction->update(['top_price' => $amount]);
    }

    public function updateStatus(Bid $bid, string $status)
    {
        $bid->update(['status' => $status]);
    }
}