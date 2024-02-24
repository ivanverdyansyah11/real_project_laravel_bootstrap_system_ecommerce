<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportRewardController;
use App\Http\Controllers\ReportTransactionController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionRewardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::fallback(function() {
    return redirect('/');
});
Route::redirect('/', '/login');

Route::middleware(['guest'])->group(function() {
    Route::controller(UserController::class)->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authentication')->name('login.authentication');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'store')->name('register.store');
    });
});

Route::middleware(['auth'])->group(function() {
    Route::controller(UserController::class)->group(function() {
        Route::post('/logout', 'logout')->name('logout');
    });
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/profile', ProfileController::class);
    Route::resource('/reseller', ResellerController::class);
    Route::resource('/customer', CustomerController::class);
    Route::resource('/cashier', CashierController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/reward', RewardController::class);
    Route::resource('/transaction', TransactionController::class);
    Route::get('/transaction-pending', [TransactionController::class, 'index'])->name('transaction-pending');
    Route::get('/transaction-finish', [TransactionController::class, 'index'])->name('transaction-finish');
    Route::resource('/report-reward', TransactionRewardController::class);
    Route::get('/report-transaction', [TransactionController::class, 'index'])->name('report-transaction');
});