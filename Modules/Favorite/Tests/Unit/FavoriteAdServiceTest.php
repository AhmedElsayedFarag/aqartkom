<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Modules\Favorite\Services\FavoriteAdService;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Ad\Entities\Ad;
use Modules\Auth\Entities\User;
use Modules\Favorite\Entities\Favorite;
use Modules\Favorite\Services\FavoriteService;
use \Illuminate\Http\JsonResponse;

use function PHPUnit\Framework\assertCount;

uses(Tests\TestCase::class);

test('test_service_will_throw_exception_with_wrong_id', function () {
    $this->expectException(ModelNotFoundException::class);
    $service = new FavoriteAdService();
    $service->validate(Str::uuid());
})->throws(ModelNotFoundException::class)
    ->group('favorite');
test('test_service_will_not_throw_exception_with_wrong_id', function () {
    $service = new FavoriteAdService();
    $ad = Ad::first();
    $id = $service->validate($ad->uuid);
    $this->assertEquals($ad->id, $id);
})
    ->group('favorite');
test('test_service_add_ad_to_favorite', function () {
    DB::table('favorites')->delete();
    $ad = Ad::first();
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'ad',
            'id' => $ad->uuid,
        ]);
    $favoriteAds = Favorite::where('favoritable_type', Ad::class)
        ->where('favoritable_id', $ad->id)
        ->where('user_id', 1)
        ->get();
    $this->assertCount(1, $favoriteAds);
})
    ->group('favorite');

test('test_service_remove_ad_from_favorite', function () {

    $ad = Ad::first();
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
    $favoriteAds = Favorite::where('favoritable_type', Ad::class)
        ->where('favoritable_id', $ad->id)
        ->where('user_id', 1)
        ->get();
    $this->assertCount(0, $favoriteAds);
})
    ->group('favorite');
test('test_service_return_all_ads_from_favorite', function () {

    $ad = Ad::first();
    DB::table('favorites')->delete();
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'ad',
            'id' => $ad->uuid,
        ]);
    $response = $this->actingAs(User::first())
        ->get('/api/v1/favorite?type=ad');
    $this->assertCount(1, $response->getData()->data);
})
    ->group('favorite');