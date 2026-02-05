<?php

namespace App\Observers;

use App\Models\Admin\Business_SetUp\BusinessSetup;
use Illuminate\Support\Facades\Cache;

class BusinessSetupObserver
{
    /**
     * Handle the BusinessSetup "saved" event.
     * This covers created and updated events.
     */
    public function saved(BusinessSetup $businessSetup): void
    {
        Cache::forget('global_business_setup');
        Cache::forget('theme_settings_active_theme');
    }

    /**
     * Handle the BusinessSetup "deleted" event.
     */
    public function deleted(BusinessSetup $businessSetup): void
    {
        Cache::forget('global_business_setup');
        Cache::forget('theme_settings_active_theme');
    }
}
