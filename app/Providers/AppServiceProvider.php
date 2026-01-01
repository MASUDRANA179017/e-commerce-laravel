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
        try {
            if (Schema::hasTable('business_setups') && Schema::hasTable('products')) {
                // Use first() to avoid throwing during migrations when no BusinessSetup row exists yet.
                $business_setup = BusinessSetup::first();
                view()->share('business_setup', $business_setup ?? null);

                // Set Mail Configuration at Runtime
                if ($business_setup) {
                    if ($business_setup->mail_mailer) {
                        config(['mail.default' => $business_setup->mail_mailer]);
                    }
                    if ($business_setup->mail_host) {
                        config(['mail.mailers.smtp.host' => $business_setup->mail_host]);
                    }
                    if ($business_setup->mail_port) {
                        config(['mail.mailers.smtp.port' => $business_setup->mail_port]);
                    }
                    if ($business_setup->mail_username) {
                        config(['mail.mailers.smtp.username' => $business_setup->mail_username]);
                    }
                    if ($business_setup->mail_password) {
                        config(['mail.mailers.smtp.password' => $business_setup->mail_password]);
                    }
                    if ($business_setup->mail_encryption) {
                        config(['mail.mailers.smtp.encryption' => $business_setup->mail_encryption]);
                    }
                    if ($business_setup->mail_from_address) {
                        config(['mail.from.address' => $business_setup->mail_from_address]);
                    }
                    if ($business_setup->mail_from_name) {
                        config(['mail.from.name' => $business_setup->mail_from_name]);
                    }
                }
            } else {
                view()->share('business_setup', null);
            }
        } catch (\Exception $e) {
            view()->share('business_setup', null);
        }
    }
}
