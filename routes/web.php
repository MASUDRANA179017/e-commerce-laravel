<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\business_settings\BusinessCatalogController;
use App\Http\Controllers\TermsConditionController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\UnitController;

/*
|--------------------------------------------------------------------------
| Frontend Routes (E-commerce Storefront)
|--------------------------------------------------------------------------
*/
require __DIR__.'/frontend.php';

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole(['Super Admin', 'Admin'])) {
        return view('dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user/dashboard', [App\Http\Controllers\Frontend\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    
Route::get('/terms-conditions', [TermsConditionController::class, 'index'])->name('terms.index');
Route::get('/terms-conditions/data', [TermsConditionController::class, 'getData'])->name('terms.data');
Route::post('/terms-conditions', [TermsConditionController::class, 'store'])->name('terms.store');
Route::get('/terms-conditions/{id}', [TermsConditionController::class, 'show'])->name('terms.show');
Route::put('/terms-conditions/{id}', [TermsConditionController::class, 'update'])->name('terms.update');
Route::delete('/terms-conditions/{id}', [TermsConditionController::class, 'destroy'])->name('terms.destroy');
});
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return redirect()->back();
});
Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return redirect()->back();
});
route::get('/business-catalog', [BusinessCatalogController::class, 'index'])->name('business-catalog.view');
route::get('/business-setup', [BusinessCatalogController::class, 'business_setup_index'])->name('business-setup.view');
// route::get('/all-attributes', [BusinessCatalogController::class, 'all_attributes_index'])->name('all-attributes.view');

// Show the contact us page


// Admin routes for contact-us
Route::get('/admin/contact', [AdminContactController::class, 'index'])->name('admin.contact');
Route::post('/admin/contact', [AdminContactController::class, 'store'])->name('admin.contact.store');

//support ticket

Route::prefix('admin')->group(function () {
    Route::get('/support/create', [SupportTicketController::class, 'create'])->name('admin.support.create');
    Route::post('/support', [SupportTicketController::class, 'store'])->name('admin.support.store');
});

//unit
Route::prefix('admin')->group(function () {
    Route::get('units', [UnitController::class, 'index'])->name('admin.units.index');
    Route::post('units/store', [UnitController::class, 'store'])->name('admin.units.store');
    Route::get('units/edit/{id}', [UnitController::class, 'edit'])->name('admin.units.edit');
    Route::delete('units/delete/{id}', [UnitController::class, 'destroy'])->name('admin.units.delete');
    Route::post('units/toggle-status/{id}', [UnitController::class, 'toggleStatus'])->name('admin.units.toggleStatus');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/user-management.php';
require __DIR__.'/business-setup.php';
require __DIR__.'/product.php';
require __DIR__.'/brand.php';
