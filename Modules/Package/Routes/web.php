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
use Modules\Package\Http\Controllers\Admin\AdFeaturePackageController;
use Modules\Package\Http\Controllers\Admin\CompanyPackageController;
use Modules\Package\Http\Controllers\Admin\CustomerPackageController;
use Modules\Package\Http\Controllers\Admin\MarketerPackageController;
use Modules\Package\Http\Controllers\Admin\PackageController;
use Modules\Package\Http\Controllers\Front\PackageController as FrontPackageController;
use Modules\Package\Http\Controllers\Front\PayPackageController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin', 'permission:manage-packages'])
    ->group(function () {
        Route::resource('package', PackageController::class)->except('show');
        Route::resource('owner-package', CustomerPackageController::class)
            ->parameter('owner-package', 'package')
            ->except('show');
        Route::resource('marketer-package', MarketerPackageController::class)
            ->parameter('marketer-package', 'package')
            ->except('show');
        Route::resource('company-package', CompanyPackageController::class)
            ->parameter('company-package', 'package')
            ->except('show');
        Route::resource('ad-feature-package', AdFeaturePackageController::class)->parameter('ad-feature-package', 'package')->except('show');
    });


Route::group(['middleware' => 'auth'], function () {
    Route::name('front.')->prefix('profile/')->group(function () {
        Route::get('pay-package/{package}', [PayPackageController::class, 'showPaymentForm'])->name('pay-package.show');
        Route::post('pay-package/{package}', [PayPackageController::class, 'payPackage'])->name('pay-package.pay');
        Route::get('packages', [FrontPackageController::class, 'index'])->name('profile.packages');
        Route::get('/subscription', [FrontPackageController::class, 'show'])->name('profile.subscription.show');
        Route::get('/cancel-subscription', [FrontPackageController::class, 'cancel'])->name('profile.subscription.cancel');
    });
});