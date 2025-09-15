<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\Storefront\OrderController;
use App\Http\Controllers\Storefront\StorefrontController;
use App\Livewire\Admin\Orders\OrderDetail as AdminOrderDetail;
use App\Livewire\Admin\Orders\OrderList;
use App\Livewire\Storefront\Cart\ShoppingCart;
use App\Livewire\Storefront\Cart\Wishlist\WishlistPage;
use App\Livewire\Storefront\Catalog\ProductCatalog;
use App\Livewire\Storefront\Checkout;
use App\Livewire\Storefront\MyAccount\Dashboard;
use App\Livewire\Storefront\MyAccount\OrderDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'index'])->name('home');
Route::get('shop', ProductCatalog::class)->name('shop');
Route::view('product/{slug?}', 'storefront.product')->name('product');
Route::get('cart', ShoppingCart::class)->name('cart');
Route::post('cart/clear', [StorefrontController::class, 'cartClear'])->name('cart.clear');
Route::get('wishlist', WishlistPage::class)->name('wishlist');
Route::get('checkout', Checkout::class)->name('checkout');
Route::get('order/{order}/confirmation', [OrderController::class, 'confirmOrder'])->name('order.confirmation');
Route::view('about', 'storefront.about')->name('about');
Route::view('contact', 'storefront.contact')->name('contact');
Route::get('blog/{slug?}', [BlogController::class, 'index'])->name('blog');
Route::view('privacy-policy', 'storefront.privacy-policy')->name('privacy-policy');
Route::view('terms-conditions', 'storefront.terms-conditions')->name('terms-conditions');
Route::view('register', 'storefront.register')->name('register');
Route::view('login', 'storefront.login')->name('login')->middleware('guest');

// Customer-only routes
Route::group(['middleware' => ['auth', 'role:customer']], function () {
    Route::get('my-account', Dashboard::class)->name('my-account');
    Route::get('my-account/order/{order}', OrderDetail::class)->name('my-account.order');
});

// Admin-only routes
Route::group(['middleware' => ['admin'], 'prefix' => 'dashboard'], function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::get('orders', OrderList::class)->name('admin.orders.index');
    Route::get('orders/{order}', AdminOrderDetail::class)->name('admin.orders.show');
});

// Vendor routes
Route::group(['middleware' => ['vendor']], function () {
    // TODO: Add vendor routes
});

require __DIR__.'/auth.php';
