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
use Modules\Auth\Http\Controllers\Admin\AdminAuthenticationController;
use Modules\Auth\Http\Controllers\Admin\AdminForgotPasswordController;
use Modules\Auth\Http\Controllers\Admin\ChangePasswordController;
use Modules\Auth\Http\Controllers\Admin\ChangeProfileController;
use Modules\Auth\Http\Controllers\AuthenticatedSessionController;
use Modules\Auth\Http\Controllers\DashboardController;
use Modules\Auth\Http\Controllers\Front\ForgetPasswordController;
use Modules\Auth\Http\Controllers\NewPasswordController;
use Modules\Auth\Http\Controllers\PasswordResetLinkController;
use Modules\Auth\Http\Controllers\Front\ProfileController;
use Modules\Auth\Http\Controllers\Front\ResetPasswordController;
use Modules\Auth\Http\Controllers\RegisterController;

// Admin routes
Route::group(['prefix' => 'dashboard'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [AdminAuthenticationController::class, 'showForm'])->name('admin.login');
        Route::post('login', [AdminAuthenticationController::class, 'store'])->name('login.store');
        Route::get('forgot-password', AdminForgotPasswordController::class)->name('admin.password.request');
    });

    Route::group(['middleware' => ['auth', 'role:admin']], function () {
        Route::any('/', DashboardController::class)->name('dashboard');
        Route::get('change-password', [ChangePasswordController::class, 'showForm'])->name('dashboard.change-password.index');
        Route::post('change-password', [ChangePasswordController::class, 'store'])->name('dashboard.change-password.store');
        Route::get('change-profile', [ChangeProfileController::class, 'showForm'])->name('dashboard.change-profile.index');
        Route::post('change-profile', [ChangeProfileController::class, 'store'])->name('dashboard.change-profile.store');
    });
});

// Shared routes
Route::group(['middleware' => 'auth'], function () {
    Route::any('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::name('front.')->prefix('profile/')->group(function () {
        Route::get('ads', [ProfileController::class, 'ads'])->name('profile.ads');
        Route::get('marketing-requests', [ProfileController::class, 'marketRequest'])->name('profile.marketRequest');
        Route::get('licence-requests', [ProfileController::class, 'licenceRequest'])->name('profile.licenceRequest');
        Route::get('licence-requests/{ad}', [ProfileController::class, 'licenceRequestState'])->name('profile.licenceRequestState');
        Route::get('bids', [ProfileController::class, 'bids'])->name('profile.bids');
        Route::get('change-data', [ProfileController::class, 'showChangeDataForm'])->name('change-data.show');
        Route::post('change-data', [ProfileController::class, 'updateProfile'])->name('change-data.update');
        Route::get('change-password', [ProfileController::class, 'showChangePasswordForm'])->name('change-password.show');
        Route::post('change-password', [ProfileController::class, 'updatePassword'])->name('change-password.update');
        Route::get('change-phone', [ProfileController::class, 'showChangePhoneForm'])->name('change-phone.show');
        Route::post('change-phone', [ProfileController::class, 'changePhone'])->name('change-phone.update');
        Route::get('verify', [ProfileController::class, 'showVerifyPhoneForm'])->name('verify-phone.show');
        Route::post('verify', [ProfileController::class, 'verifyPhone'])->name('verify-phone');
        Route::get('favorites', [ProfileController::class, 'favorites'])->name('favorites');
        Route::get('company-profile', [ProfileController::class, 'showCompanyProfileForm'])->name('company-profile.show');
        Route::post('company-profile', [ProfileController::class, 'updateCompanyProfile'])->name('company-profile.store');
    });
});
Route::post('', []);
Route::name('front.')->middleware(['guest'])->group(function () {
    Route::view('login', 'auth::front-end.login')->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::view('register', 'auth::front-end.register')->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');
    Route::view('forget-password', 'auth::front-end.forget-password')->name('forget-password');
    Route::post('forget-password', ForgetPasswordController::class)->name('forget-password.store');
    Route::get('reset-password', [ResetPasswordController::class, 'showForm'])->name('reset-password');
    Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('reset-password.store');
});