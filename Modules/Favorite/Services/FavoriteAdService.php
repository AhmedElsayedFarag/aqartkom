<?php

namespace Modules\Favorite\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Transformers\AdsResource;
use Modules\Favorite\Contracts\FavoriteInterface;

class FavoriteAdService implements FavoriteInterface
{

    public function  toggle(int $modelID)
    {
        return auth()->user()->favoriteAds()->toggle($modelID);
    }
    public function getAll()
    {
        return auth()->user()->favoriteAds()->with([
            'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address']),
            'estate.media' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
            'estate.category' => fn ($query) => $query->select(['id', 'name']),
            'estate.city' => fn ($query) => $query->select(['id', 'name']),
            'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'phone', 'type']),
        ])->paginate(15);
    }
    public function validate(string $modelUUID): int|ModelNotFoundException
    {
        return Ad::select(['id'])->where('uuid', $modelUUID)->firstOrFail()?->id;
    }
    public function toJson(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return AdsResource::collection($this->getAll());
    }
    public function render(): JsonResponse
    {
        $ads = $this->getAll();
        return response()->json([
            'data' => view('ad::front.ads-container', ['ads' => $ads, 'isFavorite' => true])->render(),
            'has_more' => $ads->hasMorePages(),
        ]);
    }
    public function isExist(int $id): bool
    {
        return auth()->user()->favoriteAds()->where('favoritable_id', $id)->exists();
    }
}