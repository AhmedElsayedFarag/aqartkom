<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Support\Facades\Route;
use Modules\Ad\Http\Controllers\AdMarketingController as ControllersAdMarketingController;
use Modules\Ad\Http\Controllers\Admin\AdController;
use Modules\Ad\Http\Controllers\Admin\AdFilterController;
use Modules\Ad\Http\Controllers\Admin\AdLicenseRequestsController;
use Modules\Ad\Http\Controllers\Admin\AdMarketingController;
use Modules\Ad\Http\Controllers\Admin\AdReportController;
use Modules\Ad\Http\Controllers\Admin\AdRequestController;
use Modules\Ad\Http\Controllers\Admin\AdVisitController;
use Modules\Ad\Http\Controllers\Front\AdRequestController as FrontAdRequestController;
use Modules\Ad\Http\Controllers\Front\User\AdsController as UserAdsController;
use Modules\Ad\Http\Controllers\Front\AdsController;
use Modules\Ad\Http\Controllers\Front\AdStepController;
use Modules\Ad\Http\Controllers\Front\CheckLicenseController;
use Modules\Ad\Http\Controllers\Front\User\AddAdLicenseController;
use Modules\Ad\Http\Controllers\Front\User\AdLicenseController;
use Modules\Ad\Http\Controllers\Front\User\AdMarketingController as UserAdMarketingController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin', 'permission:manage-ads'])
    ->group(function () {
        Route::resource('ad', AdController::class);
        Route::get('unlicensed-ad', [AdController::class, 'unlicensed'])->name('ad.unlicensed');
        // Route::resource('ad-market', AdMarketingController::class);
        //ad marketing routes
        Route::get('/ad-marketing', [AdMarketingController::class, 'index'])->name('ad-marketing.index');
        Route::get('/ad-marketing/create', [AdMarketingController::class, 'create'])->name('ad-marketing.create');
        Route::post('/ad-marketing/store', [AdMarketingController::class, 'store'])->name('ad-marketing.store');
        // Route::get('ad-requests', [AdController::class, 'requests'])->name('ad-requests.index');
        Route::resource('ad-visit', AdVisitController::class)->only(['index', 'destroy'])
            ->parameter('ad-visit', 'visit');
        Route::resource('ad-request', AdRequestController::class)
            ->parameter('ad-request', 'request');
        Route::resource('ad-report', AdReportController::class)->only(['index', 'destroy'])
            ->parameter('ad-report', 'report');
        Route::get('ad-filter-age', [AdFilterController::class, 'editAge'])->name('ad-filter-age.index');
        Route::put('ad-filter-age', [AdFilterController::class, 'updateAge'])->name('ad-filter-age.update');
        Route::resource('ad-filter', AdFilterController::class)->only(['index', 'edit', 'update'])
            ->parameter('ad-filter', 'filter');
        Route::put('ad/{ad}/accept', [AdController::class, 'accept'])->name('ad.accept');
        Route::put('ad/{ad}/cancel', [AdController::class, 'cancel'])->name('ad.cancel');
        Route::get('ad/{ad}/show-invoice', [AdController::class, 'showInvoice'])->name('ad.show-invoice');
        Route::get('ad-license-requests-completed', [AdLicenseRequestsController::class, 'completed'])->name('ad-license-requests-completed.index');
        Route::get('ad-license-requests-pending', [AdLicenseRequestsController::class, 'pending'])->name('ad-license-requests-pending.index');
        Route::get('ad/{ad}/verify', [AdLicenseRequestsController::class, 'verify'])->name('ad.verify');
        Route::put('ad/{ad}/verifyAd', [AdLicenseRequestsController::class, 'verifyAd'])->name('ad.verifyAd');

        Route::put('ad-request/{ad}/accept', [AdRequestController::class, 'accept'])->name('ad_request.accept');
        Route::put('ad-request/{ad}/cancel', [AdRequestController::class, 'cancel'])->name('ad_request.cancel');
    });

Route::get('aqar', [AdsController::class, 'index'])->name('front.aqar.index');
Route::get('marketing-requests', [ControllersAdMarketingController::class, 'index'])->name('front.marketing-requests.index')->middleware(['auth']);
Route::get('aqar/{ad}', [AdsController::class, 'show'])->name('front.aqar.show');

//ad-request-front
Route::get('aqar/requests', [FrontAdRequestController::class, 'index'])->name('front.aqar.requests.index');
Route::get('aqar/requests/{ad}', [FrontAdRequestController::class, 'show'])->name('front.aqar.requests.show');

Route::name('front.')->group(function () {

    Route::get('user/check-license', [CheckLicenseController::class, 'showForm'])->name('user.check-license.show-form');
    Route::post('user/check-license', [CheckLicenseController::class, 'store'])->name('user.check-license.store');
    Route::get('user/ad-ajax', [UserAdsController::class, 'ajax'])->name('user.ad.ajax')->middleware(['auth']);
    Route::get('user/ad-marketing-ajax', [UserAdMarketingController::class, 'ajax'])->name('user.ad.marketing')->middleware(['auth']);
    Route::get('user/ad-licence-ajax', [AdLicenseController::class, 'ajax'])->name('user.ad.licence')->middleware(['auth']);
    Route::post('user/ad/{ad}/refresh', [UserAdsController::class, 'refresh'])->name('user.ad.refresh')->middleware(['auth']);
    Route::post('user/ad/{ad}/active', [UserAdsController::class, 'active'])->name('user.ad.active')->middleware(['auth']);
    Route::post('user/ad/{ad}/unactive', [UserAdsController::class, 'unactive'])->name('user.ad.unactive')->middleware(['auth']);
    Route::delete('user/ad/{ad}', [UserAdsController::class, 'destroy'])->name('user.ad.destroy')->middleware(['auth']);
    Route::resource('user/ad', UserAdsController::class)->except(['show'])->middleware(['auth']);
    Route::delete('user/media/{media}', [UserAdsController::class, 'destroyMedia'])->name('user.ad.media.destroy')->middleware(['auth']);
    Route::get('user/ad-steps', [AdStepController::class, "showForm"])->name('user.ad-steps.show-form')->middleware(['auth']);
    Route::post('user/ad-steps', [AdStepController::class, "redirect"])->name('user.ad-steps.redirect')->middleware(['auth']);
    Route::resource('ad-marketing', UserAdMarketingController::class)->only(['create', 'store'])->middleware(['auth']);
    Route::resource('license-request', AdLicenseController::class)->only(['create', 'store'])->middleware(['auth']);
    Route::get('/user/{ad}/add-license-number', [AddAdLicenseController::class, 'showForm'])->name('user.ad.add-license-number')->middleware(['auth']);
    Route::post('/user/{ad}/add-license-number', [AddAdLicenseController::class, 'store'])->name('user.ad.add-license-number.store')->middleware(['auth']);
    Route::get('/user/ad/{ad}/add-feature', [UserAdsController::class, 'addFeature'])->name('user.ad.add-feature')->middleware(['auth']);
    Route::get('/user/show-ad-feature', [UserAdsController::class, 'showFeatureForm'])->name('user.ad.show-feature-form')->middleware(['auth']);
    Route::post('/user/ad/{ad}/buy-ad-feature', [UserAdsController::class, 'buyAdFeature'])->name('user.ad.buy-feature')->middleware(['auth']);
});