<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\Storefront\OrderController;
use App\Http\Controllers\Storefront\StorefrontController;
use App\Livewire\Storefront\Cart\ShoppingCart;
use App\Livewire\Storefront\Catalog\ProductCatalog;
use App\Livewire\Storefront\Checkout;
use App\Livewire\Storefront\MyAccount\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'index'])->name('home');
Route::get('shop', ProductCatalog::class)->name('shop');
Route::view('product/{slug?}', 'storefront.product')->name('product');
Route::get('cart', ShoppingCart::class)->name('cart');
Route::post('cart/clear', [StorefrontController::class, 'cartClear'])->name('cart.clear');
Route::view('wishlist', 'storefront.wishlist')->name('wishlist');
Route::get('checkout', Checkout::class)->name('checkout');
Route::get('order/{order}/confirmation', [OrderController::class, 'confirmOrder'])->name('order.confirmation');
Route::view('about', 'storefront.about')->name('about');
Route::view('contact', 'storefront.contact')->name('contact');
Route::get('blog/{slug?}', [BlogController::class, 'index'])->name('blog');
Route::view('privacy-policy', 'storefront.privacy-policy')->name('privacy-policy');
Route::view('terms-conditions', 'storefront.terms-conditions')->name('terms-conditions');
Route::view('register', 'storefront.register')->name('register');
Route::view('login', 'storefront.login')->name('login')->middleware('guest');

/*
Auth routes
*/

Route::group(['middleware' => 'auth'], function () {
    // Profile route accessible to all authenticated users
    Route::view('profile', 'profile')->name('profile');
});

// Customer-only routes
Route::group(['middleware' => ['auth', 'role:customer']], function () {
    Route::get('my-account', Dashboard::class)->name('my-account');
});

// Admin-only routes
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    // TODO: Add admin routes
});

// Vendor-only routes
Route::group(['middleware' => ['auth', 'role:vendor']], function () {
    // TODO: Add vendor routes
});

// Multi-role routes (admin and vendor)
Route::group(['middleware' => ['auth', 'role:admin,vendor']], function () {
    // TODO: Add admin and vendor routes
});

require __DIR__.'/auth.php';
