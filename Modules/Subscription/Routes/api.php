<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Subscription\Http\Controllers\Api\OwnerSubscriptionController;
use Modules\Subscription\Http\Controllers\Api\SubscriptionController;

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

Route::apiResource('subscription', SubscriptionController::class);
Route::apiResource('owner-subscription', OwnerSubscriptionController::class)->only(['index', 'store']);
Route::post('owner-subscription/cancel', [OwnerSubscriptionController::class, 'cancel']);
