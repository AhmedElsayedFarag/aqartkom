<?php

namespace Modules\Favorite\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Transformers\AuctionResource;
use Modules\Favorite\Contracts\FavoriteInterface;

class FavoriteAuctionService implements FavoriteInterface
{
    public function  toggle(int $modelID)
    {
        return auth()->user()->favoriteAuctions()->toggle($modelID);
    }
    public function getAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return auth()->user()->favoriteAuctions()->with([
            'estate',
            'estate.media',
            'estate.category',
            'estate.city',
        ])->paginate();
    }
    public function validate(string $modelUUID): int|ModelNotFoundException
    {
        return Auction::select(['id'])->where('uuid', $modelUUID)->firstOrFail()?->id;
    }
    public function toJson(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return AuctionResource::collection($this->getAll());
    }
    public function render(): JsonResponse
    {
        $auctions = $this->getAll();
        return response()->json([
            'data' => view('auction::front.auctions-container', ['auctions' => $auctions, 'isFavorite' => true])->render(),
            'has_more' => $auctions->hasMorePages(),
        ]);
    }
    public function isExist(int $id): bool
    {
        return auth()->user()->favoriteAuctions()->where('favoritable_id', $id)->exists();
    }
}