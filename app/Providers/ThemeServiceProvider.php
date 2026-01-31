<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            // Check if table exists to prevent errors during migration
            if (Schema::hasTable('business_setups')) {
                $settings = DB::table('business_setups')->select('active_theme')->first();
                $activeTheme = $settings ? $settings->active_theme : 'theme1';
                
                if (empty($activeTheme)) {
                    $activeTheme = 'theme1';
                }

                $themePath = resource_path("views/themes/{$activeTheme}");
                
                if (is_dir($themePath)) {
                    // Prepend the theme path so it takes precedence
                    View::getFinder()->prependLocation($themePath);
                }
            }
        } catch (\Exception $e) {
            // Ignore errors during setup/migration
        }
    }
}
