<?php

namespace Modules\Auction\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auction\DataTransferObjects\BidDto;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\Bid;
use Modules\Auction\Http\Requests\BidFilterRequest;
use Modules\Auction\Http\Requests\BidStoreRequest;
use Modules\Auction\Services\BidService;

class BidController extends Controller
{

    public function ajax(BidFilterRequest $request)
    {
        $bidService = new BidService();
        $bids = $bidService->getUserBidRequests(auth()->id(), $request->get('status'));

        return response()->json([
            'data' =>  view('auction::front.bids.container', compact('bids'))->render(),
            'has_more' => $bids->hasMorePages(),
        ]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('auction::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Auction $auction)
    {
        $auction->load([
            'estate.details',
            'estate.details.attribute',
            'estate.details.attributeValue',
        ]);
        return view('auction::front.bids.create', compact('auction'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BidStoreRequest $request, Auction $auction)
    {
        $bidService = new BidService();
        $bidDto = new BidDto($request);
        $bid = $bidService->createOrUpdate($auction, $bidDto);
        return \redirect()->route('front.auction.show', $auction->uuid);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Auction $auction)
    {
        $bid = Bid::where('user_id', auth()->id())
            ->where('auction_id', $auction->id)
            ->firstOrFail();
        return view('auction::front.bids.edit', compact('auction', 'bid'));
    }
}