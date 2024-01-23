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
use Modules\Estate\Http\Controllers\EstateGalleryController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::resource('estate/{estate}/media', EstateGalleryController::class)->except(['show', 'update', 'edit']);

        // Route::resource("category/{category}/attribute")->except(['index', 'store']);
    });