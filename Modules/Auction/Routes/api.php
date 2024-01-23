<?php

use Illuminate\Support\Facades\Route;
use Modules\Auction\Http\Controllers\Api\AuctionController;
use Modules\Auction\Http\Controllers\Api\BidController;
use Modules\Auction\Http\Controllers\Api\BidRequestController;

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


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('auction/bid-request', [BidController::class, 'index']);
    Route::post('auction/{auction}/bid', [BidController::class, 'store']);
    Route::get('auction/{auction}/bid', [BidController::class, 'show']);
});
Route::resource('auction', AuctionController::class)->only(['index', 'show']);