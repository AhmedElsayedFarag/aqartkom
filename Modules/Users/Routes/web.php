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
use Modules\Ad\Entities\AdFilter;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Auth\Entities\User;
use Modules\Category\Services\CategoriesService;
use Modules\City\Services\CitiesService;
use Modules\Users\Http\Controllers\Admin\AdminController;
use Modules\Users\Http\Controllers\Admin\CompaniesController;
use Modules\Users\Http\Controllers\Admin\CustomersController;
use Modules\Users\Http\Controllers\Admin\OwnersController;
use Modules\Users\Http\Controllers\Admin\MarketersController;
use Modules\Users\Http\Controllers\Admin\RolesController;
use Modules\Users\Http\Controllers\Front\CompaniesController as FrontCompaniesController;
use Modules\Users\Http\Controllers\Front\MarketersController as FrontMarketersController;

Route::get('share-company/{company}', function (CompanyProfile $company) {
})->name('share-company');

Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'role:admin',])
    ->group(function () {
        Route::middleware(['permission:manage-admins'])->group(function () {
            Route::resource('admin', AdminController::class)
                ->parameter('admin', 'user');

            Route::resource('role', RolesController::class);
        });
        Route::middleware('permission:manage-users')->group(function () {
            Route::resource('owner', OwnersController::class)
                ->parameter('owner', 'user')
                ->except(['create', 'store']);
            Route::resource('customer', CustomersController::class)
                ->parameter('customer', 'user')
                ->except(['create', 'store']);
            Route::resource('marketer', MarketersController::class)
                ->parameter('marketer', 'user')
                ->except(['create', 'store']);
            Route::get('marketer/{user}/featured', [MarketersController::class, 'setIsFeatured'])->name('marketer.featured');
            Route::resource('company', CompaniesController::class)
                ->parameter('company', 'user')
                ->except(['create', 'store']);
            Route::get('company/{user}/featured', [CompaniesController::class, 'setIsFeatured'])->name('company.featured');
            Route::post('owner/send-topic', [OwnersController::class, 'sendTopic'])->name('owner.send-topic');
            Route::post('company/send-topic', [CompaniesController::class, 'sendTopic'])->name('company.send-topic');
            Route::post('marketer/send-topic', [MarketersController::class, 'sendTopic'])->name('marketer.send-topic');
            Route::post('customer/send-topic', [CustomersController::class, 'sendTopic'])->name('customer.send-topic');
            Route::post('send-message', [CustomersController::class, 'sendMessage'])->name('send-message');
            Route::get('/owner-export', [OwnersController::class, 'exportExcel'])->name('owner.export');
            Route::get('/customer-export', [CustomersController::class, 'exportExcel'])->name('customer.export');
            Route::get('/customers-otps', [CustomersController::class, 'otps'])->name('customers-otps.index');
        });

        Route::post('user/{user}/toggle-block', function (User $user) {
            $user->is_blocked = !$user->is_blocked;
            $user->save();
            return redirect()->back();
        })->name('toggle-block');
    });

Route::get('company', [FrontCompaniesController::class, 'index'])->name('front.companies');
Route::get('company/{company}', [FrontCompaniesController::class, 'show'])->name('front.companies.show');

Route::get('/marketers', [FrontMarketersController::class, 'index'])->name('front.marketers');

Route::get('marketer/{marketer}', function (User $marketer) {
    abort_if(!$marketer->hasRole('marketer'), 404);
    $categories = CategoriesService::getAll();
    $filters = AdFilter::select(['name', 'group', 'values'])->get()->groupBy('group')->toArray();
    $cities = CitiesService::getAll();

    return view('users::front.marketer-ads', \compact('marketer', 'categories', 'filters', 'cities'));
})->name('front.marketer.show');