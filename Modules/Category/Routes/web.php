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
use Modules\Category\Http\Controllers\Admin\CategoriesController;
use Modules\Category\Http\Controllers\Admin\CategoryAttributeController;
use Modules\Category\Http\Controllers\Admin\FeaturedCategoriesController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin', 'permission:manage-categories'])
    ->group(function () {
        Route::resource('category', CategoriesController::class)->except('show');
        Route::resource('category/{category}/attribute', CategoryAttributeController::class);
        Route::resource('featured-category', FeaturedCategoriesController::class)
            ->parameter('featured-category', 'category')
            ->except('show');
        // Route::resource("category/{category}/attribute")->except(['index', 'store']);
    });
