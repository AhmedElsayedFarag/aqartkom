<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\BotQuestion\Http\Api\V1\Controllers\BotQuestionController;

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

Route::get('bot-question', [BotQuestionController::class, 'index']);
Route::get('bot-question/{content}', [BotQuestionController::class, 'show']);