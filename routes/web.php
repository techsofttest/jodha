<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\SearchController; 

use App\Http\Controllers\CustomerAuthController;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CartController;

use App\Http\Controllers\ArticalController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');


Route::get('/category', [CategoryController::class, 'show'])->name('category.index');
Route::get('/category/{slug}', [CategoryController::class, 'showDetails'])->name('category.show');

Route::get('/subcategory', [SubCategoryController::class, 'show'])->name('subcategory.index');
Route::get('/subcategory/{slug}', [SubCategoryController::class, 'showDetails'])->name('subcategory.show');

Route::get('/collections', [CollectionController::class, 'show'])->name('collections.index');
Route::get('/collections/{slug}', [CollectionController::class, 'detail'])->name('collections.show');

Route::get('/article', [ArticalController::class, 'index'])->name('article.index');
Route::get('/article/{slug}', [ArticalController::class, 'detail'])->name('article.show');

Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{slug}', [ProductController::class, 'showDetails'])->name('product.show');

Route::get('/search-suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Cart AJAX routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
Route::post('/order/place', [CartController::class, 'placeOrder'])->name('order.place');
Route::get('/order/success', [CartController::class, 'success'])->name('order.success');

Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');

Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::post('/customer/register', [CustomerAuthController::class, 'sendOTP']); // Changed to sendOTP as that's the first step


Route::post('/customer/send-otp', [CustomerAuthController::class, 'sendOTP']);
Route::post('/customer/verify-otp', [CustomerAuthController::class, 'verifyOTP']);

Route::get('/auth/google', [CustomerAuthController::class, 'redirectGoogle']);
Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogle']);

Route::post('/customer/logout', [CustomerAuthController::class, 'logout']);

Route::middleware('auth:customer')->group(function () {
    Route::get('/profile/dashboard', [ProfileController::class, 'index'])->name('profile.dashboard');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});


// Route::get('/live', function () {
//     Artisan::call('optimize');
//     Artisan::call('storage:link');
//     return '<h3>✅ Optimized & Linked successfully!</h3>';
// });