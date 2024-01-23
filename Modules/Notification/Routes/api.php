<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\NotificationsController;

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


Route::controller(NotificationsController::class)->middleware('auth:sanctum')->prefix('notification')->group(function () {
    Route::get('', 'index');
    Route::delete('', 'destroy');
    Route::delete('{notification}', 'destroyOne');
    Route::put('{notification}', 'read');
    Route::post('read-all', 'readAll');
});