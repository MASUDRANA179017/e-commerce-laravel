<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| These routes handle the public-facing e-commerce storefront.
|
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop / Products
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Product Reviews (requires auth)
Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])
    ->name('product.review')
    ->middleware('auth');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{rowId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/coupon', [CartController::class, 'applyCoupon'])->name('coupon');
});

// Checkout Routes (requires auth)
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

// Static Pages
Route::get('/about', function () {
    return view('frontend.about');
})->name('frontend.about');

Route::get('/contact', [ContactController::class, 'index'])->name('frontend.contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Additional static pages
Route::get('/terms-and-conditions', function () {
    return view('frontend.terms');
})->name('frontend.terms');

Route::get('/privacy-policy', function () {
    return view('frontend.privacy');
})->name('frontend.privacy');

Route::get('/faq', function () {
    return view('frontend.faq');
})->name('frontend.faq');

