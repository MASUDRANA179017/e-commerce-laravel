<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StorefrontController;
use App\Http\Controllers\Admin\MarketingController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SettingsController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All admin panel routes for the e-commerce system
|
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    /*
    |--------------------------------------------------------------------------
    | Orders Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/data', [OrderController::class, 'getData'])->name('data');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        Route::post('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
        Route::get('/abandoned', [OrderController::class, 'abandoned'])->name('abandoned');
        Route::get('/returns', [OrderController::class, 'returns'])->name('returns');
        Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');
        Route::get('/{order}/print', [OrderController::class, 'printOrder'])->name('print');
    });

    /*
    |--------------------------------------------------------------------------
    | Customers Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/data', [CustomerController::class, 'getData'])->name('data');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
        Route::post('/{customer}/status', [CustomerController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/groups', [CustomerController::class, 'groups'])->name('groups');
        Route::post('/groups', [CustomerController::class, 'storeGroup'])->name('groups.store');
        Route::put('/groups/{group}', [CustomerController::class, 'updateGroup'])->name('groups.update');
        Route::delete('/groups/{group}', [CustomerController::class, 'destroyGroup'])->name('groups.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Reports & Analytics
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/sales/data', [ReportController::class, 'salesData'])->name('sales.data');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('/inventory/data', [ReportController::class, 'inventoryData'])->name('inventory.data');
        Route::get('/customers', [ReportController::class, 'customers'])->name('customers');
        Route::get('/customers/data', [ReportController::class, 'customersData'])->name('customers.data');
        Route::get('/export/{type}', [ReportController::class, 'export'])->name('export');
    });

    /*
    |--------------------------------------------------------------------------
    | Storefront Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('storefront')->name('storefront.')->group(function () {
        Route::get('/customizer', [StorefrontController::class, 'customizer'])->name('customizer');
        Route::post('/customizer', [StorefrontController::class, 'saveCustomizer'])->name('customizer.save');
        Route::get('/pages', [StorefrontController::class, 'pages'])->name('pages');
        Route::get('/pages/create', [StorefrontController::class, 'createPage'])->name('pages.create');
        Route::post('/pages', [StorefrontController::class, 'storePage'])->name('pages.store');
        Route::get('/pages/{page}/edit', [StorefrontController::class, 'editPage'])->name('pages.edit');
        Route::put('/pages/{page}', [StorefrontController::class, 'updatePage'])->name('pages.update');
        Route::delete('/pages/{page}', [StorefrontController::class, 'destroyPage'])->name('pages.destroy');
        Route::get('/menus', [StorefrontController::class, 'menus'])->name('menus');
        Route::post('/menus', [StorefrontController::class, 'storeMenu'])->name('menus.store');
        Route::put('/menus/{menu}', [StorefrontController::class, 'updateMenu'])->name('menus.update');
        Route::delete('/menus/{menu}', [StorefrontController::class, 'destroyMenu'])->name('menus.destroy');
        Route::get('/blog', [StorefrontController::class, 'blog'])->name('blog');
        Route::get('/blog/create', [StorefrontController::class, 'createBlog'])->name('blog.create');
        Route::post('/blog', [StorefrontController::class, 'storeBlog'])->name('blog.store');
        Route::get('/blog/{post}/edit', [StorefrontController::class, 'editBlog'])->name('blog.edit');
        Route::put('/blog/{post}', [StorefrontController::class, 'updateBlog'])->name('blog.update');
        Route::delete('/blog/{post}', [StorefrontController::class, 'destroyBlog'])->name('blog.destroy');
        Route::get('/banners', [StorefrontController::class, 'banners'])->name('banners');
        Route::post('/banners', [StorefrontController::class, 'storeBanner'])->name('banners.store');
        Route::put('/banners/{banner}', [StorefrontController::class, 'updateBanner'])->name('banners.update');
        Route::delete('/banners/{banner}', [StorefrontController::class, 'destroyBanner'])->name('banners.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Marketing
    |--------------------------------------------------------------------------
    */
    Route::prefix('marketing')->name('marketing.')->group(function () {
        Route::get('/coupons', [MarketingController::class, 'coupons'])->name('coupons');
        Route::get('/coupons/data', [MarketingController::class, 'couponsData'])->name('coupons.data');
        Route::post('/coupons', [MarketingController::class, 'storeCoupon'])->name('coupons.store');
        Route::get('/coupons/{coupon}', [MarketingController::class, 'showCoupon'])->name('coupons.show');
        Route::put('/coupons/{coupon}', [MarketingController::class, 'updateCoupon'])->name('coupons.update');
        Route::delete('/coupons/{coupon}', [MarketingController::class, 'destroyCoupon'])->name('coupons.destroy');
        Route::post('/coupons/{coupon}/toggle', [MarketingController::class, 'toggleCoupon'])->name('coupons.toggle');
        Route::get('/flash-sales', [MarketingController::class, 'flashSales'])->name('flash-sales');
        Route::post('/flash-sales', [MarketingController::class, 'storeFlashSale'])->name('flash-sales.store');
        Route::put('/flash-sales/{sale}', [MarketingController::class, 'updateFlashSale'])->name('flash-sales.update');
        Route::delete('/flash-sales/{sale}', [MarketingController::class, 'destroyFlashSale'])->name('flash-sales.destroy');
        Route::get('/newsletters', [MarketingController::class, 'newsletters'])->name('newsletters');
        Route::get('/newsletters/subscribers', [MarketingController::class, 'subscribers'])->name('newsletters.subscribers');
        Route::post('/newsletters', [MarketingController::class, 'sendNewsletter'])->name('newsletters.send');
        Route::delete('/newsletters/subscriber/{subscriber}', [MarketingController::class, 'deleteSubscriber'])->name('newsletters.subscriber.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Inventory Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/stock', [InventoryController::class, 'stock'])->name('stock');
        Route::get('/stock/data', [InventoryController::class, 'stockData'])->name('stock.data');
        Route::post('/stock/adjust', [InventoryController::class, 'adjustStock'])->name('stock.adjust');
        Route::get('/stock/low', [InventoryController::class, 'lowStock'])->name('stock.low');
        Route::get('/purchases', [InventoryController::class, 'purchases'])->name('purchases');
        Route::get('/purchases/create', [InventoryController::class, 'createPurchase'])->name('purchases.create');
        Route::post('/purchases', [InventoryController::class, 'storePurchase'])->name('purchases.store');
        Route::get('/purchases/{purchase}', [InventoryController::class, 'showPurchase'])->name('purchases.show');
        Route::put('/purchases/{purchase}', [InventoryController::class, 'updatePurchase'])->name('purchases.update');
        Route::delete('/purchases/{purchase}', [InventoryController::class, 'destroyPurchase'])->name('purchases.destroy');
        Route::get('/vendors', [InventoryController::class, 'vendors'])->name('vendors');
        Route::post('/vendors', [InventoryController::class, 'storeVendor'])->name('vendors.store');
        Route::get('/vendors/{vendor}', [InventoryController::class, 'showVendor'])->name('vendors.show');
        Route::put('/vendors/{vendor}', [InventoryController::class, 'updateVendor'])->name('vendors.update');
        Route::delete('/vendors/{vendor}', [InventoryController::class, 'destroyVendor'])->name('vendors.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('general');
        Route::post('/email', [SettingsController::class, 'updateEmail'])->name('email');
        Route::post('/payment', [SettingsController::class, 'updatePayment'])->name('payment');
        Route::post('/shipping', [SettingsController::class, 'updateShipping'])->name('shipping');
        Route::post('/tax', [SettingsController::class, 'updateTax'])->name('tax');
        Route::post('/currency', [SettingsController::class, 'updateCurrency'])->name('currency');
        Route::post('/social', [SettingsController::class, 'updateSocial'])->name('social');
        Route::post('/seo', [SettingsController::class, 'updateSeo'])->name('seo');
    });
});

