<?php

namespace Modules\Auction\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auction\DataTransferObjects\BidDto;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\Bid;
use Modules\Auction\Http\Requests\BidFilterRequest;
use Modules\Auction\Http\Requests\BidRequest;
use Modules\Auction\Http\Requests\BidStoreRequest;
use Modules\Auction\Services\BidService;
use Modules\Auction\Transformers\BidRequestResource;
use Modules\Auction\Transformers\BidResource;
use Symfony\Component\HttpFoundation\Response;

class BidController extends Controller
{

    public function __construct(private BidService $bidService)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Illuminate\Support\Facades\Response
     */
    public function index(BidFilterRequest $request)
    {
        $bids = $this->bidService->getUserBidRequests(auth()->id(), $request->get('status'));
        return BidRequestResource::collection($bids);
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function store(BidStoreRequest $request, Auction $auction)
    {
        $bidDto = new BidDto($request);
        $bid = $this->bidService->createOrUpdate($auction, $bidDto);
        return $bid->wasRecentlyCreated ? JsonResponseMessages::created() : JsonResponseMessages::updated();
    }

    /**
     * Show the specified resource.
     * @return Illuminate\Support\Facades\Response
     */
    public function show(Auction $auction)
    {
        $bid = Bid::where('user_id', auth()->id())
            ->where('auction_id', $auction->id)
            ->firstOrFail();
        return new BidResource($bid);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Illuminate\Support\Facades\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Illuminate\Support\Facades\Response
     */
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Illuminate\Support\Facades\Response
     */
    public function destroy($id)
    {
        //
    }
}