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
use Modules\Favorite\Http\Controllers\FavoriteController;
use Modules\Favorite\Http\Controllers\Front\FavoritesController;

Route::get('favorite', FavoritesController::class)->name('front.favorite.index');
Route::post('favorite', [FavoriteController::class, 'toggle'])->name('front.favorite.toggle');