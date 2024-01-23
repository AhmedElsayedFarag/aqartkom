<?php

namespace Modules\Auction\Http\Controllers\Api;

use App\Helpers\FavoriteTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\AuctionView;
use Modules\Auction\Services\AuctionService;
use Modules\Auction\Transformers\AuctionResource;
use Modules\Auction\Transformers\AuctionShowResource;

class AuctionController extends Controller
{
    use FavoriteTrait;
    /**
     * Display a listing of the resource.
     * @return Illuminate\Support\Facades\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'closed' => 'boolean',
            'search' => 'sometimes|string|min:3|max:120|nullable',
            'city'  => 'sometimes|numeric|exists:cities,id'
        ]);
        return AuctionResource::collection(AuctionService::getAll($request->closed));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param string $uuid
     * @return Illuminate\Support\Facades\Response
     */
    public function show(Auction $auction)
    {
        if (auth('sanctum')->check())
            AuctionView::updateOrCreate(
                ['user_id' => auth('sanctum')->id(), 'auction_id' => $auction->id]
            );
        $auction->is_favorite = $this->addIsFavorite($auction->id, Auction::class);
        return new AuctionShowResource($auction);
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
    public function update(Request $request, $id)
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