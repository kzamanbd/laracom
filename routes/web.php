<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StorefrontController;

Route::view('/', 'storefront.home')->name('home');
Route::get('shop', [StorefrontController::class, 'shop'])->name('shop');
Route::view('product/{slug?}', 'storefront.product')->name('product');
Route::view('cart', 'storefront.cart')->name('cart');
Route::view('wishlist', 'storefront.wishlist')->name('wishlist');
Route::view('checkout', 'storefront.checkout')->name('checkout');
Route::view('my-account', 'storefront.my-account')->name('my-account');
Route::view('about', 'storefront.about')->name('about');
Route::view('contact', 'storefront.contact')->name('contact');
Route::get('blog/{slug?}', function ($slug = null) {
    // Logic to fetch and display a specific blog post based on the slug
    if ($slug) {
        return view('storefront.blog-show', ['slug' => $slug]);
    }
    // Logic to display a list of blog posts
    return view('storefront.blog');
})->name('blog');
Route::view('privacy-policy', 'storefront.privacy-policy')->name('privacy-policy');
Route::view('terms-conditions', 'storefront.terms-conditions')->name('terms-conditions');
Route::view('register', 'storefront.register')->name('register');
Route::view('login', 'storefront.login')->name('login');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
