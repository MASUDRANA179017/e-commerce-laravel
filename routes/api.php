<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\NewsletterController;

Route::get('/products-data', [ProductController::class, 'index']);

// Newsletter endpoints
Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('unsubscribe');
    Route::post('/check-status', [NewsletterController::class, 'checkStatus'])->name('check-status');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
