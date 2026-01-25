<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $table = 'shipping_zones';

    protected $fillable = [
        'name',
        'description',
        'type',
        'configuration',
        'base_charge',
        'is_active',
        'priority',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope: Get active zones
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('priority', 'asc');
    }

    /**
     * Get zones by country
     */
    public function scopeByCountry($query, $country)
    {
        return $query->where('type', 'country')
            ->whereJsonContains('configuration->countries', $country);
    }
}
