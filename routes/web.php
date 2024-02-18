<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportRewardController;
use App\Http\Controllers\ReportTransactionController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\TransactionController;
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

Route::middleware(['guest'])->group(function() {
    Route::controller(DashboardController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller(ResellerController::class)->group(function() {
        Route::get('/reseller', 'index')->name('reseller');
    });

    Route::controller(CustomerController::class)->group(function() {
        Route::get('/customer', 'index')->name('customer');
    });

    Route::controller(ProductController::class)->group(function() {
        Route::get('/product', 'index')->name('product');
    });

    Route::controller(RewardController::class)->group(function() {
        Route::get('/reward', 'index')->name('reward');
    });

    Route::controller(TransactionController::class)->group(function() {
        Route::get('/transaction', 'index')->name('transaction');
    });

    Route::controller(ReportRewardController::class)->group(function() {
        Route::get('/report-reward', 'index')->name('report-reward');
    });

    Route::controller(ReportTransactionController::class)->group(function() {
        Route::get('/report-transaction', 'index')->name('report-transaction');
    });
});