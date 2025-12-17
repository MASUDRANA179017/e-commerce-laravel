<?php

use App\Http\Controllers\Admin\Product\CreateProductApiController;
use App\Http\Controllers\Admin\Product\ProductCategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Product Category Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('product')->name('product.')->controller(ProductCategoryController::class)->group(function () {
        Route::get('/category', 'index')->name('category.index');
        Route::post('/categories/store', 'store')->name('categories.store');
        Route::get('/categories/parents', 'getParents')->name('categories.parents');
        Route::get('/categories/{id}/edit', 'edit')->name('categories.edit');
        Route::get('/categories/tree', 'getTree')->name('categories.tree');
        Route::delete('/categories/{id}', 'destroy')->name('categories.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Create Product Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('create-product')->name('product-create.')->controller(ProductController::class)->group(function () {
        Route::get('/', 'create')->name('index');
        Route::post('/store', 'store')->name('store');
    });

    /*
    |--------------------------------------------------------------------------
    | Edit Product Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');


    /*
    |--------------------------------------------------------------------------
    | All Products + Delete + Update Status Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/all-products', [ProductController::class, 'allProducts'])->name('product.all');

    // Delete Product (Dynamic delete)
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])
        ->name('product.destroy');

    // Update Status
    Route::post('/product/{id}/update-status', [ProductController::class, 'updateStatus'])
        ->name('product.updateStatus');

    // images
    Route::get('/product/{id}/images', [ProductController::class, 'getImages'])->name('product.images');
    Route::delete('/product/{productId}/image/{imageId}', [ProductController::class, 'deleteImage'])->name('product.deleteImage');
    Route::get('/product/{id}/image-count', [ProductController::class, 'imageCount']);



    Route::get('/product/{id}/images', [ProductController::class, 'getImages'])->name('product.images');
    Route::get('/product/{id}/variants', [ProductController::class, 'getVariants'])->name('product.variants');
    Route::get('/product/{id}/details', [ProductController::class, 'getProductDetails'])->name('product.details');

});



/*
|--------------------------------------------------------------------------
| Public / API Product Category Routes
|--------------------------------------------------------------------------
*/
Route::get('/product/categories/leaf', [ProductCategoryController::class, 'leaf']);   // [{id,slug,path}]
Route::get('/product/categories/tree', [ProductCategoryController::class, 'tree']);   // nested tree


/*
|--------------------------------------------------------------------------
| Product API Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/all-attributes/data', [CreateProductApiController::class, 'attributesAll']);   // -> {attributes:[...]}
Route::get('/catalog/attribute-sets/data', [CreateProductApiController::class, 'attributeSets']);  // -> {sets:[...]}
Route::post('/product/get/varient-rules', [CreateProductApiController::class, 'variantRules']);    // body:{attribute_set_id}
Route::get('/catalog/categories/{slug}/config', [CreateProductApiController::class, 'categoryConfig']); // -> per primary category
