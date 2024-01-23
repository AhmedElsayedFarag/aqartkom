<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Package\Http\Controllers\Api\PackageController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('packages', [PackageController::class, 'index']);
    Route::get('ad-feature-packages', \Modules\Package\Http\Controllers\Api\AdFeaturePackageController::class);
});
Route::get('all-packages', [PackageController::class, 'getAll']);
// Route::get('owner-packages', \Modules\Package\Http\Controllers\Api\CustomerPackageController::class);