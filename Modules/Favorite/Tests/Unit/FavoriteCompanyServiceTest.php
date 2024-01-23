<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Modules\Favorite\Services\FavoriteCompanyService;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Ad\Entities\Ad;
use Modules\Auth\Entities\User;
use Modules\Favorite\Entities\Favorite;
use Modules\Favorite\Services\FavoriteService;
use \Illuminate\Http\JsonResponse;
use Modules\Auction\Entities\Auction;
use Modules\Auth\Entities\CompanyProfile;

use function PHPUnit\Framework\assertCount;

uses(Tests\TestCase::class);

test('test_service_will_throw_exception_with_wrong_id', function () {
    $this->expectException(ModelNotFoundException::class);
    $service = new FavoriteCompanyService();
    $service->validate(Str::uuid());
})->throws(ModelNotFoundException::class)
    ->group('favorite');
test('test_service_will_not_throw_exception_with_wrong_id', function () {
    $service = new FavoriteCompanyService();
    $company = CompanyProfile::first();
    $id = $service->validate($company->uuid);
    $this->assertEquals($company->id, $id);
})
    ->group('favorite');
test('test_service_add_company_to_favorite', function () {
    DB::table('favorites')->delete();
    $company = CompanyProfile::first();
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'company',
            'id' => $company->uuid,
        ]);
    $favoriteAds = Favorite::where('favoritable_type', CompanyProfile::class)
        ->where('favoritable_id', $company->id)
        ->where('user_id', 1)
        ->get();
    $this->assertCount(1, $favoriteAds);
})
    ->group('favorite');

test('test_service_remove_company_from_favorite', function () {

    $ad = CompanyProfile::first();
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
    $favoriteAds = Favorite::where('favoritable_type', CompanyProfile::class)
        ->where('favoritable_id', $ad->id)
        ->where('user_id', 1)
        ->get();
    $this->assertCount(0, $favoriteAds);
})
    ->group('favorite');
test('test_service_return_all_companys_from_favorite', function () {

    $company = CompanyProfile::first();
    DB::table('favorites')->delete();
    $this->actingAs(User::first())
        ->post('/api/v1/favorite', [
            'type' => 'company',
            'id' => $company->uuid,
        ]);
    $response = $this->actingAs(User::first())
        ->get('/api/v1/favorite?type=company');
    $this->assertCount(1, $response->getData()->data);
})
    ->group('favorite');