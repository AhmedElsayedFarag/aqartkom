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
use Modules\Coupon\Http\Controllers\AdminCouponController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin', 'permission:manage-coupon'])
    ->group(function () {
        Route::resource('coupon', AdminCouponController::class)->except('show');

        Route::put('/coupon/deactivate/{coupon}' , [AdminCouponController::class , 'deactivate'])->name('coupon.deactivate');
    });
