<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';
    protected $fillable = ['key', 'value', 'type'];

    /**
     * Get a setting by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Convert value based on type
        switch ($setting->type) {
            case 'boolean':
                return in_array($setting->value, ['1', 'true', true], true);
            case 'number':
                return is_numeric($setting->value) ? (float) $setting->value : $setting->value;
            case 'json':
                return json_decode($setting->value, true);
            default:
                return $setting->value;
        }
    }

    /**
     * Set a setting
     */
    public static function set($key, $value, $type = 'string')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Get scout discount enabled status
     */
    public static function scoutDiscountEnabled()
    {
        return static::get('scout_discount_enabled', true);
    }

    /**
     * Get scout discount percentage
     */
    public static function scoutDiscountPercent()
    {
        return static::get('scout_discount_percent', 10);
    }

    /**
     * Get scout discount code
     */
    public static function scoutDiscountCode()
    {
        return static::get('scout_discount_code', 'SCOUT');
    }
}
