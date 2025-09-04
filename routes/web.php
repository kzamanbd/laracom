<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'frontend.home')->name('home');
Route::view('shop', 'frontend.shop')->name('shop');
Route::view('product/{slug?}', 'frontend.product')->name('product');
Route::view('cart', 'frontend.cart')->name('cart');
Route::view('checkout', 'frontend.checkout')->name('checkout');
Route::view('my-account', 'frontend.my-account')->name('my-account');
Route::view('about', 'frontend.about')->name('about');
Route::view('contact', 'frontend.contact')->name('contact');
Route::get('blog/{slug?}', function ($slug = null) {
    // Logic to fetch and display a specific blog post based on the slug
    if ($slug) {
        return view('frontend.blog-show', ['slug' => $slug]);
    }
    // Logic to display a list of blog posts
    return view('frontend.blog');
})->name('blog');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
