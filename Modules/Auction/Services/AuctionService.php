<?php

namespace Modules\Auction\Services;

use Exception;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Modules\Auction\DataTransferObjects\AuctionDto;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Enums\BidRequestStatusEnum;
use Modules\Auction\Exceptions\AuctionIsClosedException;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Filters\City;
use Modules\Estate\Filters\Search;
use Modules\Estate\Services\EstateService;
use Symfony\Component\HttpFoundation\Response;

class AuctionService
{
    public static function getAdminAll($closed = null)
    {
        return app(Pipeline::class)
            ->send(Auction::select(['auctions.id', 'uuid', 'initial_price', 'top_price', 'is_closed', 'end_at', 'estate_id'])
                ->join('estates', 'estates.id', '=', 'auctions.estate_id')
                ->with([
                    'estate' => fn ($query) => $query->select(['id',  'title',]),
                ]))
            ->through([
                City::class,
                Search::class,
            ])
            ->thenReturn()
            ->closed($closed)
            ->orderBy('auctions.created_at', 'DESC')
            ->paginate(15);
    }
    /**
     * Get all auctions.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getAll($closed = null)
    {
        return app(Pipeline::class)->send(Auction::select(['auctions.id', 'uuid', 'initial_price', 'top_price', 'is_closed', 'end_at', 'estate_id'])
            ->join('estates', 'estates.id', '=', 'auctions.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long']),
                'estate.images' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                'estate.category' => fn ($query) => $query->select(['id', 'name']),
                'estate.city' => fn ($query) => $query->select(['id', 'name']),
            ]))
            ->through([
                City::class,
                Search::class,
            ])
            ->thenReturn()
            ->closed($closed)
            ->orderBy('auctions.created_at', 'DESC')
            ->paginate(15);
    }


    public function createOrUpdate(AuctionDto $auctionDto, EstateDto $estateDto, ?Auction $auction = null): ?Auction
    {
        DB::transaction(function () use (&$auction, $estateDto, $auctionDto) {
            $estateService = new EstateService();
            if (is_null($auction)) {
                $estate = $estateService->createOrUpdate($estateDto);
                $auctionDto->setEstateID($estate->id);
                $auction = Auction::create(
                    $auctionDto->toArray()
                );
            } else {
                $estate = $estateService->createOrUpdate($estateDto, $auction->estate);
                $auctionDto->setEstateID($estate->id);
                $auction->update([
                    ...$auctionDto->toArray(),
                ]);
            }
        });
        // $this->loadRelations($ad);
        return $auction;
    }
    /**
     * Update auction.
     *
     * @param \Modules\Auction\Entities\Auction auction
     * @param  Array  $auctionData
     * @return \Modules\Auction\Entities\Auction
     */
    public static function update(Auction &$auction, $auctionData)
    {
        return $auction->update($auctionData);
    }

    /**
     * Delete auction.
     *
     * @param \Modules\Auction\Entities\Auction $auction
     */
    public static function delete(Auction $auction)
    {
        return $auction->delete();
    }

    /**
     * Terminate auction.
     *
     * @param \Modules\Auction\Entities\Auction $auction
     * @return \Modules\Auction\Entities\Auction $auction
     */
    public static function terminate(Auction &$auction)
    {
        self::update($auction, ['is_closed' => 1, 'end_at' => now()]);
        $auction->bids()->update(['status' => BidRequestStatusEnum::CLOSED]);
        return true;
    }


    public static function checkIfClosed(Auction $auction)
    {
        if ($auction->isClosed()) {
            self::terminate($auction);
            throw new AuctionIsClosedException();
        }
    }
}