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
use Modules\CustomerMessage\Http\Controllers\Admin\CustomerMessagesController;

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('customer-message', CustomerMessagesController::class)->only(['index', 'destroy']);
});
