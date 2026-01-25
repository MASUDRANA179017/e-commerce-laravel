<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Admin\CustomerController;
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
// Route::get('/', function () {
//     return 'Root Route Works';
// });

// Flash Sale page
Route::get('/flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');

// Shop / Products
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{id}/variants', [ProductController::class, 'variants'])->name('product.variants');
Route::get('/product/{id}/quick-view', [ProductController::class, 'quickView'])->name('product.quickView');

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
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Wishlist Routes
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add', [WishlistController::class, 'add'])->name('add');
    Route::delete('/remove/{productId}', [WishlistController::class, 'remove'])->name('remove');
    Route::delete('/clear', [WishlistController::class, 'clear'])->name('clear');
    Route::get('/count', [WishlistController::class, 'count'])->name('count');
    Route::post('/move-to-cart/{productId}', [WishlistController::class, 'moveToCart'])->name('moveToCart');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    Route::post('/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('calculate-shipping');
});

use App\Http\Controllers\Frontend\PageController;

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('frontend.about');
Route::get('/contact', [ContactController::class, 'index'])->name('frontend.contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Additional static pages
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('frontend.terms');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('frontend.terms.alt');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('frontend.privacy');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('frontend.page');


Route::get('/faq', function () {
    return view('frontend.faq');
})->name('frontend.faq');

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\Frontend\BlogController::class, 'show'])->name('show');
});
Route::prefix('customer')->name('customer.')->group(function () {

    Route::post('login', [CustomerController::class, 'login']);

    Route::middleware('auth:customer')->group(function () {
        Route::post('logout', [CustomerController::class, 'logout'])->name('logout');
    });
});

// Dynamic CMS pages served at root, avoiding reserved prefixes
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!api|admin|shop|product|cart|wishlist|checkout|blog|flash-sale|terms-and-conditions|privacy-policy|about|contact|user|dashboard|login|register|forgot-password|reset-password|verify-email|confirm-password|email|catalog).+$');

