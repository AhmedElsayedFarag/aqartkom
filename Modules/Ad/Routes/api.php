<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Ad\Http\Controllers\Api\AdFilterController;
use Modules\Ad\Http\Controllers\Api\AdController;
use Modules\Ad\Http\Controllers\Api\AdLicenseController;
use Modules\Ad\Http\Controllers\Api\AdMarketingController;
use Modules\Ad\Http\Controllers\Api\AdMarketingUserController;
use Modules\Ad\Http\Controllers\Api\AdRequestController;
use Modules\Ad\Http\Controllers\Api\AdRequestUserController;
use Modules\Ad\Http\Controllers\Api\AdTypeController;
use Modules\Ad\Http\Controllers\Api\AdUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('ad-request/{request}', [AdRequestController::class, 'show']);
Route::post('ad-request', [AdRequestController::class, 'index']);

Route::get('ad/{ad}', [AdController::class, 'show']);
Route::post('ad', [AdController::class, 'index']);
Route::post('ad-map', [AdController::class, 'getMapAds']);

Route::post('ad-marketing', [AdMarketingController::class, 'index'])->middleware('auth:sanctum');
Route::get('ad-marketing/{ad}/contact', [AdMarketingController::class, 'contact'])->middleware('auth:sanctum');


Route::get('ad-filters', AdFilterController::class);
Route::post('ad/{ad}/report', [AdController::class, 'report']);
Route::post('ad/{ad}/visit', [AdController::class, 'visit']);
Route::get('ad-types', AdTypeController::class);
Route::middleware('auth:sanctum')->prefix('user')->name('user.')->group(function () {
    Route::apiResource('ad', AdUserController::class);
    Route::apiResource('ad-market', AdMarketingUserController::class)->parameter('ad-market', 'ad');
    Route::post('ad-market/{ad}/add-license-number', [AdMarketingUserController::class, 'addLicenseNumber']);
    Route::post('ad/{ad}/active', [AdUserController::class, 'active']);
    Route::post('ad/{ad}/unactive', [AdUserController::class, 'unactive']);
    Route::delete('ad/{ad}/media/{media}', [AdUserController::class, 'deleteMedia']);
    Route::post('ad/{ad}/refresh', [AdUSerController::class, 'refresh']);
    Route::post('ad/{ad}/feature', [AdUSerController::class, 'addFeature']);

    Route::get('/license-ad-request', [AdLicenseController::class, 'index']);
    Route::post('/license-ad-request', [AdLicenseController::class, 'store']);
    Route::get('/license-ad-request/{ad}', [AdLicenseController::class, 'show']);
    Route::put('/license-ad-request/{ad}', [AdLicenseController::class, 'update']);
    Route::post('/license-ad-request/{ad}/cancel', [AdLicenseController::class, 'cancel']);
    Route::post('/license-ad-request/{ad}/pay-fees', [AdLicenseController::class, 'payFees']);

    Route::post('ad/{ad}/buy-ad-feature', [AdUSerController::class, 'buyAdFeature']);
    Route::apiResource('ad-request', AdRequestUserController::class);
    // Route::post('ad-request/{ad_request}/active', [AdRequestUserController::class, 'active']);
    // Route::post('ad-request/{ad_request}/unactive', [AdRequestUserController::class, 'unactive']);
    // Route::post('ad-request/{ad_request}/refresh', [AdRequestUserController::class, 'refresh']);
    // Route::post('ad-request/{ad_request}/feature', [AdRequestUserController::class, 'addFeature']);
});
Route::get('ad-search', [AdController::class, 'search'])->name('ad.search');