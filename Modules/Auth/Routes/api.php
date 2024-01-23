<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\AuthenticatedTokenController;
use Modules\Auth\Http\Controllers\Api\CompanyProfileController;
use Modules\Auth\Http\Controllers\Api\ForgotPasswordController;
use Modules\Auth\Http\Controllers\Api\GenerateOtpController;
use Modules\Auth\Http\Controllers\Api\ProfileController;
use Modules\Auth\Http\Controllers\Api\RegisteredUserController;
use Modules\Auth\Http\Controllers\Api\ResetPasswordController;
use Modules\Auth\Transformers\AuthUserResource;

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

Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', RegisteredUserController::class);
    Route::post('/login', [AuthenticatedTokenController::class, 'store']);
    Route::post('/nafath-login', [AuthenticatedTokenController::class, 'loginByNafath']);
    Route::post('/forgot-password', ForgotPasswordController::class);
    Route::post('/reset-password', ResetPasswordController::class);
    Route::post('/generate-otp', GenerateOtpController::class);
    Route::post('/verify-phone', [ProfileController::class, 'verifyNewNumber']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('company-profile', [CompanyProfileController::class, 'store']);
    Route::get('company-profile', [CompanyProfileController::class, 'show']);
    Route::put('company-profile', [CompanyProfileController::class, 'update']);
    Route::post('/logout', [AuthenticatedTokenController::class, 'logout']);
    Route::delete('/user-delete', [AuthenticatedTokenController::class, 'destroy']);
    Route::get('user-data', function () {
        return new AuthUserResource(request()->user());
    });
    Route::prefix('change/')->controller(ProfileController::class)->group(function () {
        Route::post('password', 'updatePassword');
        Route::post('profile-image', 'updateProfileImage');
        Route::post('profile', 'updateProfile');
        Route::post('phone', 'updatePhone');
        Route::post('verify-account', 'verifyAccount')->name('verify-account');
    });

    Route::post('/ping', fn () => response('ping'));
});
