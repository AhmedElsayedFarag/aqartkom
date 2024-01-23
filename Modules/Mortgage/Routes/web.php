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
use Modules\Mortgage\Http\Controllers\Admin\MortgageController;
use Modules\Mortgage\Http\Controllers\Front\MortgageController as FrontMortgageController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin', 'permission:manage-mortgages'])
    ->group(function () {
        Route::resource('mortgage', MortgageController::class)->only(['index', 'destroy']);
        Route::get('mortgage-export', [MortgageController::class, 'export'])->name('mortgage.export');
    });

Route::get('mortgage', [FrontMortgageController::class, 'showForm'])->name('front.mortgage.showForm');
Route::post('mortgage', [FrontMortgageController::class, 'store'])->name('front.mortgage.store');
