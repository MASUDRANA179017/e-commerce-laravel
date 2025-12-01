<?php

use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Controllers\Admin\Brand\BrandTemplateController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::prefix('brand')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store-or-update', 'storeOrUpdate')->name('storeOrUpdate');
        Route::get('/list', 'getBrands')->name('list');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
        Route::post('/toggle-feature', 'toggleFeature')->name('toggleFeature');
        Route::post('/toggle-active', 'toggleActive')->name('toggleActive');

        Route::post('/storeIntoBrand', 'storeIntoBrand')->name('storeIntoBrand');
    });

    Route::prefix('brand')->name('brand.')->controller(BrandTemplateController::class)->group(function () {
        

    });

    
});
