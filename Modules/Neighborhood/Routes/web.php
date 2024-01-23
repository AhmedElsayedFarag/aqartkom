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
use Modules\Neighborhood\Http\Controllers\Admin\NeighborhoodController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin', 'permission:manage-cities'])
    ->group(function () {
        Route::resource('city/{city}/neighborhood', NeighborhoodController::class)->except('show');
    });