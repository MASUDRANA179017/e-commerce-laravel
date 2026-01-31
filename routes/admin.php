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
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\Marketing\DiscountController;
use App\Http\Controllers\Admin\Settings\ShippingController;
use App\Http\Controllers\Admin\Settings\PaymentSettingsController;
use App\Http\Controllers\Admin\PosController;

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
    | POS System
    |--------------------------------------------------------------------------
    */
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::get('/search', [PosController::class, 'searchProducts'])->name('search');
        Route::post('/store', [PosController::class, 'store'])->name('store');
    });

    /*
    |--------------------------------------------------------------------------
    | Orders Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/data', [OrderController::class, 'getData'])->name('data');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::get('/abandoned', [OrderController::class, 'abandoned'])->name('abandoned');
        Route::get('/returns', [OrderController::class, 'returns'])->name('returns');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        Route::post('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
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
        Route::post('/pages/upload-image', [StorefrontController::class, 'uploadPageImage'])->name('pages.upload_image');
        Route::get('/pages/{page}/edit', [StorefrontController::class, 'editPage'])->name('pages.edit');
        Route::put('/pages/{page}', [StorefrontController::class, 'updatePage'])->name('pages.update');
        Route::delete('/pages/{page}', [StorefrontController::class, 'destroyPage'])->name('pages.destroy');
        Route::get('/menus', [StorefrontController::class, 'menus'])->name('menus');
        Route::post('/menus', [StorefrontController::class, 'storeMenu'])->name('menus.store');
        Route::put('/menus/{menu}', [StorefrontController::class, 'updateMenu'])->name('menus.update');
        Route::delete('/menus/{menu}', [StorefrontController::class, 'destroyMenu'])->name('menus.destroy');
        Route::get('/common-images', [StorefrontController::class, 'commonImages'])->name('common-images');
        Route::post('/common-images', [StorefrontController::class, 'updateCommonImages'])->name('common-images.update');
        Route::get('/banners', [StorefrontController::class, 'banners'])->name('banners');
        Route::get('/ads-sections', [StorefrontController::class, 'adsSections'])->name('ads-sections');
        Route::post('/banners', [StorefrontController::class, 'storeBanner'])->name('banners.store');
        Route::put('/banners/{banner}', [StorefrontController::class, 'updateBanner'])->name('banners.update');
        Route::delete('/banners/{banner}', [StorefrontController::class, 'destroyBanner'])->name('banners.destroy');

        // FAQ Management (Moved to Storefront)
        Route::get('/faqs', [FAQController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/create', [FAQController::class, 'create'])->name('faqs.create');
        Route::post('/faqs', [FAQController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [FAQController::class, 'edit'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [FAQController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [FAQController::class, 'destroy'])->name('faqs.destroy');
        Route::post('/faqs/{faq}/toggle', [FAQController::class, 'toggleStatus'])->name('faqs.toggle-status');
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
        Route::get('/flash-sales/{sale}', [MarketingController::class, 'showFlashSale'])->name('flash-sales.show');
        Route::post('/flash-sales', [MarketingController::class, 'storeFlashSale'])->name('flash-sales.store');
        Route::put('/flash-sales/{sale}', [MarketingController::class, 'updateFlashSale'])->name('flash-sales.update');
        Route::delete('/flash-sales/{sale}', [MarketingController::class, 'destroyFlashSale'])->name('flash-sales.destroy');
        Route::post('/flash-sales/{sale}/toggle', [MarketingController::class, 'toggleFlashSale'])->name('flash-sales.toggle');
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
        Route::post('/stock/adjust-variant', [InventoryController::class, 'adjustVariantStock'])->name('stock.adjustVariant');
        Route::get('/stock/low', [InventoryController::class, 'lowStock'])->name('stock.low');

        // Purchases - Order matters! Specific routes must come BEFORE {purchase} parameter
        Route::get('/purchases', [InventoryController::class, 'purchases'])->name('purchases');
        Route::get('/purchases/trash', [InventoryController::class, 'trashedPurchases'])->name('purchases.trash');
        Route::get('/purchases/create', [InventoryController::class, 'createPurchase'])->name('purchases.create');
        Route::post('/purchases', [InventoryController::class, 'storePurchase'])->name('purchases.store');

        // Parameterized routes for single purchase
        Route::delete('/purchases/{purchase}/force', [InventoryController::class, 'forceDeletePurchase'])->name('purchases.force-delete');
        Route::post('/purchases/{purchase}/restore', [InventoryController::class, 'restorePurchase'])->name('purchases.restore');
        Route::delete('/purchases/{purchase}', [InventoryController::class, 'destroyPurchase'])->name('purchases.destroy');
        Route::put('/purchases/{purchase}', [InventoryController::class, 'updatePurchase'])->name('purchases.update');
        Route::get('/purchases/{purchase}', [InventoryController::class, 'showPurchase'])->name('purchases.show');

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
        Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('update-general');
        Route::post('/localization', [SettingsController::class, 'updateLocalization'])->name('update-localization');
        Route::post('/store-info', [SettingsController::class, 'updateStoreInfo'])->name('update-store-info');
        Route::post('/email', [SettingsController::class, 'updateEmail'])->name('update-email');
        Route::post('/payment', [SettingsController::class, 'updatePayment'])->name('update-payment');
        Route::post('/shipping-settings', [SettingsController::class, 'updateShipping'])->name('update-shipping');
        Route::post('/scout-discount', [SettingsController::class, 'updateScout'])->name('update-scout');
        Route::post('/tax', [SettingsController::class, 'updateTax'])->name('update-tax');
        Route::post('/currency', [SettingsController::class, 'updateCurrency'])->name('update-currency');
        Route::post('/social', [SettingsController::class, 'updateSocial'])->name('update-social');
        Route::post('/seo', [SettingsController::class, 'updateSeo'])->name('update-seo');

        // Holidays
        Route::post('/holidays', [SettingsController::class, 'publicHolidaysStore'])->name('holidays.store');
        Route::delete('/holidays/{id}', [SettingsController::class, 'publicHolidaysDelete'])->name('holidays.delete');

        // Documents
        Route::post('/documents', [SettingsController::class, 'documentsStore'])->name('documents.store');
        Route::delete('/documents/{id}', [SettingsController::class, 'documentsDelete'])->name('documents.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Blog Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\BlogController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\BlogController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\BlogController::class, 'store'])->name('store');
        Route::get('/{blog}/edit', [\App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('edit');
        Route::put('/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'update'])->name('update');
        Route::delete('/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Newsletter Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('newsletters')->name('newsletters.')->group(function () {
        Route::get('/', [NewsletterController::class, 'index'])->name('index');
        Route::delete('/{newsletter}', [NewsletterController::class, 'destroy'])->name('destroy');
        Route::get('/export', [NewsletterController::class, 'export'])->name('export');
        Route::post('/send', [NewsletterController::class, 'send'])->name('send');
    });

    /*
    |--------------------------------------------------------------------------
    | Discount Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('discounts')->name('discounts.')->group(function () {
        Route::get('/', [DiscountController::class, 'index'])->name('index');
        Route::get('/create', [DiscountController::class, 'create'])->name('create');
        Route::post('/', [DiscountController::class, 'store'])->name('store');
        Route::get('/{discount}/edit', [DiscountController::class, 'edit'])->name('edit');
        Route::put('/{discount}', [DiscountController::class, 'update'])->name('update');
        Route::delete('/{discount}', [DiscountController::class, 'destroy'])->name('destroy');
        Route::post('/{discount}/toggle', [DiscountController::class, 'toggleStatus'])->name('toggle-status');
    });

    /*
    |--------------------------------------------------------------------------
    | Advanced Settings
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->name('settings.')->group(function () {
        // Shipping
        Route::prefix('shipping')->name('shipping.')->group(function () {
            Route::get('/', [ShippingController::class, 'index'])->name('index');
            Route::get('/create', [ShippingController::class, 'create'])->name('create');
            Route::post('/', [ShippingController::class, 'store'])->name('store');
            Route::get('/{zone}/edit', [ShippingController::class, 'edit'])->name('edit');
            Route::put('/{zone}', [ShippingController::class, 'update'])->name('update');
            Route::delete('/{zone}', [ShippingController::class, 'destroy'])->name('destroy');
            Route::post('/{zone}/toggle', [ShippingController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Payment Settings
        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('/', [PaymentSettingsController::class, 'index'])->name('index');
            Route::post('/', [PaymentSettingsController::class, 'update'])->name('update');
        });
    });
});

