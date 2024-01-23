<?php

namespace Modules\Auction\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auction\DataTransferObjects\BidDto;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Http\Requests\AuctionFilterRequest;
use Modules\Auction\Http\Requests\BidRequest;
use Modules\Auction\Http\Requests\BidStoreRequest;
use Modules\Auction\Services\AuctionService;
use Modules\Auction\Services\BidService;
use Modules\City\Services\CitiesService;
use Modules\Favorite\Services\FavoriteAuctionService;
use Modules\Favorite\Services\FavoriteService;

class AuctionController extends Controller
{

    public function filter(AuctionFilterRequest $request)
    {
        $auctions = AuctionService::getAll($request->closed)->withQueryString();
        return response()->json([
            'data' => view('auction::front.auctions-container', compact('auctions'))->render()
        ]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AuctionFilterRequest $request)
    {
        $cities = CitiesService::getAll();
        $auctions = AuctionService::getAll($request->closed)->withQueryString();
        return view('auction::front.index', compact('cities', 'auctions'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Auction $auction)
    {
        $auction->load([
            'estate.details',
            'estate.details.attribute',
            'estate.details.attributeValue',
        ]);
        $isFavorite = auth()->check() ? (new FavoriteService(new FavoriteAuctionService))->isExist($auction->id) : false;
        return view('auction::front.show', compact('auction', 'isFavorite'));
    }
    public function bid(Auction $auction)
    {
        $auction->load([
            'estate.details',
            'estate.details.attribute',
            'estate.details.attributeValue',
        ]);
        return view('auction::front.participant', compact('auction'));
    }
    public function participant(BidStoreRequest $request, Auction $auction)
    {
        $bidService = new BidService();
        $bidDto = new BidDto($request);
        $bid = $bidService->createOrUpdate($auction, $bidDto);
        return \redirect()->route('front.auction.show', $auction->uuid);
    }
}