<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Api\CategoryController;
use Modules\Category\Http\Controllers\Api\FeaturedCategoryController;

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

Route::prefix('category')->controller(CategoryController::class)->group(function () {
    Route::get('', 'index');
    Route::get('/{category}/attributes', 'attributes');
});


Route::get('featured-category', FeaturedCategoryController::class);