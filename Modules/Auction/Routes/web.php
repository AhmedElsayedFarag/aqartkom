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
use Modules\Auction\Http\Controllers\Admin\AuctionBidController;
use Modules\Auction\Http\Controllers\Admin\AuctionController;
use Modules\Auction\Http\Controllers\Admin\BidRequestController;
use Modules\Auction\Http\Controllers\Front\AuctionController as FrontAuctionController;
use Modules\Auction\Http\Controllers\Front\BidController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin', 'permission:manage-auctions'])
    ->group(function () {
        Route::resource('auction', AuctionController::class);
        Route::post('auction/{auction}/terminate', [AuctionController::class, 'terminate'])->name('auction.terminate');
        Route::get('bid-request', [BidRequestController::class, 'index'])->name('bid-request.index');
        Route::put('bid-request/{bid}/accept', [BidRequestController::class, 'accept'])->name('bid-request.accept');
        Route::put('bid-request/{bid}/cancel', [BidRequestController::class, 'cancel'])->name('bid-request.cancel');
        Route::resource('auction/{auction}/bid', AuctionBidController::class);
        // Route::resource("category/{category}/attribute")->except(['index', 'store']);
    });

Route::name('front.')->group(function () {
    Route::resource('auction', FrontAuctionController::class)->only(['index', 'show']);
    Route::middleware('auth')->group(function () {
        Route::get('user/bids-ajax', [BidController::class, 'ajax'])->name('user.bids');
        Route::get('auction/{auction}/bid', [BidController::class, 'create'])->name('auction.bid.show');
        Route::post('auction/{auction}/bid', [BidController::class, 'store'])->name('auction.bid.store');
        Route::get('auction/{auction}/bid-edit', [BidController::class, 'edit'])->name('auction.bid.edit');
    });
});