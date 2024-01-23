<?php

namespace Modules\Auction\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\Bid;
use Modules\Auction\Http\Requests\BidStoreRequest;
use Modules\Auction\Services\BidService;

class AuctionBidController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Auction $auction)
    {
        $bids = $auction->bids()
            ->when(request()->get('search'), function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('national_number', 'like', "%$search%");
            })
            ->paginate(15);
        return view('auction::admin.bids.index', compact('auction', 'bids'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Auction $auction, Bid $bid)
    {
        return view('auction::admin.bids.edit', compact('auction', 'bid'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BidStoreRequest $request, Auction $auction, Bid $bid)
    {
        $bidService = new BidService();
        //check bid is high
        $bid->update($request->validated());
        if ($bidService->isHigh($auction, (int)$request->amount))
            $bidService->updateAuctionTopPrice($bid->auction, $request->amount);

        return success_update('bid.index', ['auction' => $auction->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Auction $auction, Bid $bid)
    {
        $bid->delete();
        return success_delete('');
    }
}