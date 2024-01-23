<?php

use Modules\Ad\Entities\Ad;
use Modules\Ad\Enums\AdStatusEnum;
use Modules\Auth\Entities\User;

uses(Tests\TestCase::class);
//filter age,area,city,category,neighborhood,type,prices,bedroom,furniture,search

test('test_rent_ads_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent');
    $rentAds = Ad::where('type', 'rent')
        ->where('status', 'approved')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell');
    $sellAds = Ad::where('type', 'sell')
        ->where('status', 'approved')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_city_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&city=5');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('type', 'sell')
        ->where('city_id', 5)
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_city_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&city=5');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('type', 'rent')
        ->where('city_id', 5)
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_category_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&category=5');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('category_id', 5)
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_category_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&category=5');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('category_id', 5)
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');


test('test_sell_ads_and_age_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&age[]=1&age[]=3');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('age', [1, 3])
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_age_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&age[]=1&age[]=3');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('age', [1, 3])
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_bedroom_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&bedroom[]=1&bedroom[]=3');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('bedroom', [1, 3])
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_bedroom_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&bedroom[]=1&bedroom[]=3');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('bedroom', [1, 3])
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');


test('test_sell_ads_and_area_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&area[]=100&area[]=10000');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('area', [100, 10000])
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_area_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&area[]=100&area[]=10000');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('area', [100, 10000])
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_prices_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&prices[]=100&prices[]=10000');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('price', [100, 10000])
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_prices_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&prices[]=100&prices[]=10000');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->whereBetween('price', [100, 10000])
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_furniture_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&is_furniture=1');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('is_furniture', 1)
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_furniture_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&is_furniture=1');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('is_furniture', 1)
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_not_furniture_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&is_furniture=0');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('is_furniture', 0)
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_not_furniture_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&is_furniture=0');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('is_furniture', 0)
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_neighborhood_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=sell&neighborhood=1');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('neighborhood_id', 1)
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_neighborhood_filter_is_applied_is_returned', function () {
    $response = $this->get('/api/v1/ad?type=rent&neighborhood=1');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('neighborhood_id', 1)
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_sell_ads_and_search_filter_is_applied_is_returned', function () {
    $ad = Ad::first();
    $ad->estate->update(['title' => 'aqar1234']);
    $response = $this->get('/api/v1/ad?type=sell&search=aqar1234');
    $sellAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('title', 'like', '%aqar1234%')
        ->where('type', 'sell')
        ->count();
    $this->assertEquals($sellAds, $response->getData()->meta->total);
})->group('ad');

test('test_rent_ads_and_search_filter_is_applied_is_returned', function () {
    $ad = Ad::first();
    $ad->estate->update(['title' => 'aqar1234']);
    $response = $this->get('/api/v1/ad?type=rent&search=aqar1234');
    $rentAds = Ad::select(['estate_id', 'uuid', 'type', 'views', 'accepted_at', 'price', 'user_id'])
        ->join('estates', 'estates.id', '=', 'ads.estate_id')
        ->where('status', AdStatusEnum::APPROVED)
        ->where('title', 'like', '%aqar1234%')
        ->where('type', 'rent')
        ->count();
    $this->assertEquals($rentAds, $response->getData()->meta->total);
})->group('ad');

test('test_admin_contact_is_returned', function () {
    $ad = Ad::select(['uuid'])
        ->where('status', 'approved')
        ->where('user_id', 1)
        ->first();
    $response = $this->get('/api/v1/ad/' . $ad->uuid);
    $this->assertEquals('+9655111111111', $response->getData()->data->phone);
    $this->assertEquals('+9655111111111', $response->getData()->data->whatsapp);
    $this->assertEquals("ادارة عقاراتكم", $response->getData()->data->owner_name);
})->group('ad');

test('test_admin_contact_is_returned_when_customer_is_owner', function () {
    $ad = Ad::select(['uuid'])
        ->where('status', 'approved')
        ->where('user_id', 2)
        ->first();
    $response = $this->get('/api/v1/ad/' . $ad->uuid);
    $this->assertEquals('+9655111111111', $response->getData()->data->phone);
    $this->assertEquals('+9655111111111', $response->getData()->data->whatsapp);
    $this->assertEquals("ادارة عقاراتكم", $response->getData()->data->owner_name);
})->group('ad');

test('test_marketer_contact_is_returned_when_customer_is_marketer', function () {
    $user = User::find(3);
    $ad = Ad::select(['uuid'])
        ->where('status', 'approved')
        ->where('user_id', 3)
        ->first();
    $response = $this->get('/api/v1/ad/' . $ad->uuid);
    $this->assertEquals($user->phone, $response->getData()->data->phone);
    $this->assertEquals($user->marketerProfile->whatsapp_number, $response->getData()->data->whatsapp);
    $this->assertEquals($user->name, $response->getData()->data->owner_name);
})->group('ad');

test('test_company_contact_is_returned_when_customer_is_company', function () {
    $user = User::find(4);
    $ad = Ad::select(['uuid'])
        ->where('status', 'approved')
        ->where('user_id', 4)
        ->first();
    $response = $this->get('/api/v1/ad/' . $ad->uuid);
    $this->assertEquals($user->phone, $response->getData()->data->phone);
    $this->assertEquals($user->companyProfile->whatsapp_number, $response->getData()->data->whatsapp);
    $this->assertEquals($user->name, $response->getData()->data->owner_name);
})->group('ad');