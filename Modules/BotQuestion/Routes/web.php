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
// use Modules\BotQuestion\Http\Admin\Controllers\BotQuestionController;

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::resource('bot-question', BotQuestionController::class)->only(['index', 'edit', 'update'])
            ->parameter('bot-question', 'question');
    });