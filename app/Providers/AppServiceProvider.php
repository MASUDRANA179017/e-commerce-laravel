<?php

namespace App\Providers;

use App\Models\Admin\Business_SetUp\BusinessSetup;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Schema;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('business_setups') && Schema::hasTable('products')) {
            $business_setups = BusinessSetup::firstorfail();
            view()->share('business_setups', $business_setups ?? null);
        } else {
            view()->share('business_setups', null);
        }
    }
}
