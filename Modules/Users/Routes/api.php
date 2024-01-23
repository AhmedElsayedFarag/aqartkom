<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\Api\MarketersController;
use Modules\Users\Http\Controllers\Api\CompaniesController;

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

Route::apiResource('company', CompaniesController::class)->only(['index', 'show']);
Route::get('company/{company}/ads', [CompaniesController::class, 'ads']);
Route::apiResource('marketer', MarketersController::class)->only(['index', 'show']);
Route::get('marketer/{marketer}/ads', [MarketersController::class, 'ads']);
Route::get('marketer/{marketer}/contact', [MarketersController::class, 'contact'])->middleware('auth:sanctum');