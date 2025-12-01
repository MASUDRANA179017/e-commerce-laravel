<?php


use App\Http\Controllers\Admin\Business_SetUp\AllAttributeController;
use App\Http\Controllers\Admin\Business_SetUp\AttributeSetController;
use App\Http\Controllers\Admin\Business_SetUp\BusinessSetUpController;
use App\Http\Controllers\Admin\Business_SetUp\Catalog\AttributeController;
use App\Http\Controllers\Admin\Business_SetUp\Catalog\CategoryController;
use App\Http\Controllers\Admin\Business_SetUp\Catalog\TermController;
use App\Http\Controllers\SizeChartController;
use App\Http\Controllers\SizeChartTemplateController;
use App\Http\Controllers\Admin\Business_SetUp\VarientBuildController;
use Illuminate\Support\Facades\Route;









Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::prefix('business-setup')->name('users.')->controller(BusinessSetUpController::class)->group(function () {
        Route::get('/', 'index')->name('business-setup.index');
        Route::get('/public-holiday', 'publicHolidays')->name('business-setup.public-holidays');
        Route::post('/public-holiday/store', 'publicHolidaysStore')->name('business-setup.public-holidays.store');
        Route::delete('/public-holiday/destroy/{id}', 'publicHolidaysDelete')->name('business-setup.public-holidays.destroy');

        Route::get('/documents', 'documents')->name('business-setup.documents');
        Route::post('/documents/store', 'documentsStore')->name('business-setup.documents.store');
        Route::delete('/documents/{id}', 'documentsDelete')->name('business-setup.documents.destroy');

        Route::put('/update/all/{id}', 'updateAll')->name('business-setup.update');
        Route::put('/prefix-update/{id}', 'prefixUpdate')->name('business-setup.prefix-update');
        Route::put('localization', [BusinessSetupController::class, 'updateLocalization'])->name('localization.update');
        Route::put('currency', [BusinessSetupController::class, 'updateCurrency'])->name('currency.update');
    });

    Route::prefix('all-attributes')->name('all-attributes.')->controller(AllAttributeController::class)->group(function () {
        Route::get('/', 'index')->name('all-attributes.index');
    });
});
Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index'); // ?category=slug
    Route::get('/attribute-sets', [AllAttributeController::class, 'attributeSetsIndex'])->name('attribute_sets.index');
    Route::post('/attribute-sets/bulk-save', [AttributeSetController::class, 'bulkSave'])->name('attribute_sets.bulk_save');
    Route::delete('attribute-sets/{attribute_set}', [AttributeSetController::class, 'destroy'])->name('attribute_sets.destroy');
    
    // term CRUD for modal
    Route::delete('/terms/{term}', [TermController::class, 'destroy'])->name('terms.destroy');
    Route::post('/terms', [TermController::class, 'store'])->name('terms.store');
    Route::patch('/terms/{term}', [TermController::class, 'update'])->name('terms.update');
});

Route::prefix('catalog/size-charts')->name('catalog.size_charts.')->group(function () {
  Route::get('data',  [SizeChartController::class, 'data'])->name('data'); 

  Route::get('templates', [SizeChartTemplateController::class, 'index'])->name('templates.index'); // optional ?category=slug
  Route::post('/', [SizeChartController::class, 'store'])->name('store'); // persist user-created chart from modal
  Route::get('/', [SizeChartController::class, 'index']) ->name('view'); // persist user-created chart from modal
  Route::match(['put','patch'],'/{chart}', [SizeChartController::class, 'update'])->name('update');
  Route::delete('/{chart}', [SizeChartController::class, 'destroy'])->name('destroy');                 // NEW
  Route::delete('/{chart}/image', [SizeChartController::class, 'destroyImage'])->name('image.destroy'); // NEW
 
});



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::prefix('varient-build')->name('users.')->controller(VarientBuildController::class)->group(function () {
        Route::get('/', 'index')->name('varient-build.index');
    });
});