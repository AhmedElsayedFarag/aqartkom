<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Modules\Favorite\Services\FavoriteAuctionService;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Ad\Entities\Ad;
use Modules\Auth\Entities\User;
use Modules\Favorite\Entities\Favorite;
use Modules\Favorite\Services\FavoriteService;
use \Illuminate\Http\JsonResponse;
use Modules\Auction\Entities\Auction;

use function PHPUnit\Framework\assertCount;

uses(Tests\TestCase::class);

test('test_service_will_throw_exception_with_wrong_id', function () {
    $this->expectException(ModelNotFoundException::class);
    $service = new FavoriteAuctionService();
    $service->validate(Str::uuid());
})->throws(ModelNotFoundException::class)
    ->group('favorite');
test('test_service_will_not_throw_exception_with_wrong_id', function () {
    $service = new FavoriteAuctionService();
    $auction = Auction::first();
    $id = $service->validate($auction->uuid);
    $this->assertEquals($auction->id, $id);
})
    ->group('favorite');
test('test_service_add_auction_to_favorite', function () {
    DB::table('favorites')->delete();
    $auction = Auction::first();
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'auction',
            'id' => $auction->uuid,
        ]);
    $favoriteAds = Favorite::where('favoritable_type', Auction::class)
        ->where('favoritable_id', $auction->id)
        ->where('user_id', 1)
        ->get();
    $this->assertCount(1, $favoriteAds);
})
    ->group('favorite');

test('test_service_remove_auction_from_favorite', function () {

    $ad = Auction::first();
    DB::table('favorites')->delete();
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'ad',
            'id' => $ad->uuid,
        ]);
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'ad',
            'id' => $ad->uuid,
        ]);
    $favoriteAds = Favorite::where('favoritable_type', Auction::class)
        ->where('favoritable_id', $ad->id)
        ->where('user_id', 1)
        ->get();
    $this->assertCount(0, $favoriteAds);
})
    ->group('favorite');
test('test_service_return_all_auctions_from_favorite', function () {

    $auction = Auction::first();
    DB::table('favorites')->delete();
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'auction',
            'id' => $auction->uuid,
        ]);
    $response = $this->actingAs(User::first())
        ->get('/api/v1/favorite?type=auction');
    $this->assertCount(1, $response->getData()->data);
})
    ->group('favorite');