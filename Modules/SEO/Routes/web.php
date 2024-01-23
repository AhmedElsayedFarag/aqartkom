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
use Modules\SEO\Http\Controllers\Admin\SEOController;

Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/seo', [SEOController::class, 'index'])->name('seo.index');
    Route::post('/seo', [SEOController::class, 'store'])->name('seo.update');
});