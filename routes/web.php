<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
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

Route::fallback(function () {
    return redirect('/');
});
Route::redirect('/', '/homepage');

Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
Route::get('/homepage/product', [HomepageController::class, 'products'])->name('products');
Route::get('/homepage/product/{id}', [HomepageController::class, 'product'])->name('product');
Route::get('/homepage/testimonial', [HomepageController::class, 'testimonial'])->name('testimonial');
Route::get('/homepage/contact', [HomepageController::class, 'contact'])->name('contact');

Route::middleware(['guest'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authentication')->name('login.authentication');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'store')->name('register.store');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
    });
    Route::resource('/dashboard', DashboardController::class)->middleware('isAdminReseller');
    Route::resource('/profile', ProfileController::class);
    Route::resource('/reseller', ResellerController::class)->middleware('isAdmin');
    Route::put('/reseller/approved/{id}', [ResellerController::class, 'approved'])->middleware('isAdmin');
    Route::resource('/cashier', CashierController::class)->middleware('isAdmin');
    Route::resource('/category', CategoryController::class)->middleware('isAdmin');
    Route::resource('/product', ProductController::class)->middleware('isAdmin');
    Route::get('/product/thumbnail-image/{id}', [ProductImageController::class, 'edit'])->middleware('isAdmin')->name('thumbnail-image');
    Route::post('/product/thumbnail-image/create', [ProductImageController::class, 'store'])->middleware('isAdmin')->name('thumbnail-image.create');
    Route::post('/product/thumbnail-image/{id}/edit', [ProductImageController::class, 'update'])->middleware('isAdmin');
    Route::post('/product/thumbnail-image/{id}/delete', [ProductImageController::class, 'destroy'])->middleware('isAdmin');
    Route::resource('/package', PackageController::class)->middleware('isAdmin');
    Route::resource('/reward', RewardController::class)->middleware('isAdminReseller');
    Route::resource('/transaction', TransactionController::class)->middleware('isAdminReseller');
    Route::get('/transaction/get_product/{id}', [TransactionController::class, 'getProduct'])->middleware('isAdmin');
    Route::get('/transaction/get_package/{quantity}/{id}', [TransactionController::class, 'getPackage']);
    Route::get('/transaction/get_package_all/{id}', [TransactionController::class, 'getPackageAll']);
    Route::put('/transaction/approved/{id}', [TransactionController::class, 'approved'])->middleware('isAdminReseller');
    Route::put('/transaction/approvedShipping/{id}', [TransactionController::class, 'approvedShipping'])->middleware('isAdminReseller');
    Route::get('/transaction-pending', [TransactionController::class, 'index'])->name('transaction-pending')->middleware('isAdmin');
    Route::get('/transaction-payment', [TransactionController::class, 'index'])->name('transaction-payment')->middleware('isAdmin');
    Route::get('/transaction-finish', [TransactionController::class, 'index'])->name('transaction-finish')->middleware('isAdmin');
    Route::get('/transaction-finish/{id}/export-invoice', [TransactionController::class, 'export'])->name('export-invoice')->middleware('isAdminReseller');
    Route::resource('/report-reward', TransactionRewardController::class)->middleware('isAdminReseller');
    Route::get('/report-transaction', [TransactionController::class, 'index'])->name('report-transaction')->middleware('isAdminReseller');

    Route::resource('/homepage/cart', CartController::class);
    Route::get('/homepage/getPayment/{id}', [CartController::class, 'getPayment'])->name('get-payment');
    Route::post('/homepage/cart-transaction', [CartController::class, 'storeTransaction'])->name('store-transaction');
    Route::post('/homepage/cart-session', [CartController::class, 'createSession'])->name('create-session');
    Route::get('/homepage/cart-transaction/{id}', [CartController::class, 'cartTransaction'])->name('cart-transaction');
    Route::put('/homepage/transaction-store-product/{id}', [CartController::class, 'storeProduct'])->name('transaction-store-product');
    Route::get('/homepage/profile', [HomepageController::class, 'profile'])->name('profile');
    Route::get('/homepage/order-completed', [HomepageController::class, 'orderCompleted'])->name('order-completed');
});
