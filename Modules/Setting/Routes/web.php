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
use Modules\Setting\Http\Controllers\Admin\SettingController;

Route::prefix('dashboard/settings/')
    ->name('dashboard.settings-')
    ->middleware(['auth', 'role:admin', 'permission:manage-settings'])
    ->controller(SettingController::class)
    ->group(function () {
        Route::get('apis', 'apis')->name('apis.index');
        Route::put('apis', 'updateApis')->name('apis.update');
        Route::get('contact-us', 'contactUs')->name('contact-us.index');
        Route::put('contact-us', 'updateContactUs')->name('contact-us.update');
        Route::get('auction', 'auction')->name('auction.index');
        Route::put('auction', 'updateAuction')->name('auction.update');
        Route::get('app', 'appSettings')->name('app.index');
        Route::put('app', 'updateApp')->name('app.update');
        Route::get('ad-feature', 'adFeatureSettings')->name('ad-feature.index');
        Route::put('ad-feature', 'updateAdFeature')->name('ad-feature.update');
        Route::get('ad-license', 'adLicenseSettings')->name('ad-license.index');
        Route::put('ad-license', 'updateAdLicense')->name('ad-license.update');
        Route::get('free-package', 'freePackageSettings')->name('free-package.index');
        Route::put('free-package', 'updateFreePackage')->name('free-package.update');
    });