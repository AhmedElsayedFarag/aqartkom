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
use Modules\Transaction\Http\Controllers\Admin\TransactionController;
use Modules\Transaction\Services\PaymentService;

Route::get('transaction', [TransactionController::class, 'index'])->middleware(['auth:sanctum', 'role:admin'])->name('dashboard.transaction.index');
Route::get('transaction/package-bills', [TransactionController::class, 'getPackageBills'])->middleware(['auth:sanctum', 'role:admin'])->name('dashboard.package_bills.index');
Route::get('transaction/package-bills/{id}', [TransactionController::class, 'showPackageBills'])->middleware(['auth:sanctum', 'role:admin'])->name('dashboard.package_bills.show');
Route::get('transaction/package-bills/edit/{id}', [TransactionController::class, 'editPackageBills'])->middleware(['auth:sanctum', 'role:admin'])->name('dashboard.package_bills.edit');
Route::put('transaction/package-bills/edit/{id}', [TransactionController::class, 'updatePackageBills'])->middleware(['auth:sanctum', 'role:admin'])->name('dashboard.package_bills.update');
Route::get('transaction-export', [TransactionController::class, 'exportExcel'])->middleware(['auth:sanctum', 'role:admin'])->name('dashboard.transaction.export-excel');

Route::get('success-payment', function () {
    $service = new PaymentService();
    $status = $service->checkPayment(request()->paymentId, request()->Id);
    return redirect()->route('payment', ['status' => $status]);
})->name('success-payment');
Route::get('failed-payment', function () {
    $service = new PaymentService();
    $status = $service->checkPayment(request()->paymentId, request()->Id);
    //return query params back
    return redirect()->route('payment', ['status' => $status]);
})->name('failed-payment');
