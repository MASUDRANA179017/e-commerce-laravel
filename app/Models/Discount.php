<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'max_discount',
        'usage_limit',
        'usage_count',
        'usage_limit_per_customer',
        'applies_to',
        'applicable_products',
        'applicable_categories',
        'minimum_purchase',
        'minimum_product_quantity',
        'customer_type',
        'is_flash_sale',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'applicable_products' => 'array',
        'applicable_categories' => 'array',
        'is_active' => 'boolean',
        'is_flash_sale' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Scope: Get active discounts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            });
    }

    /**
     * Scope: Get active flash sales
     */
    public function scopeFlashSales($query)
    {
        return $query->where('is_flash_sale', true)->active();
    }

    /**
     * Scope: Get discounts applicable to specific product
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where(function ($q) use ($productId) {
            $q->where('applies_to', 'all_products')
                ->orWhereJsonContains('applicable_products', $productId);
        });
    }

    /**
     * Check if discount usage limit is exceeded
     */
    public function isUsageLimitExceeded()
    {
        if (!$this->usage_limit) {
            return false;
        }
        return $this->usage_count >= $this->usage_limit;
    }

    /**
     * Calculate discount amount for a given price
     */
    public function calculateDiscount($price)
    {
        if ($this->type === 'percentage') {
            $discount = ($price * $this->value) / 100;
            return min($discount, $this->max_discount ?? $discount);
        }
        return $this->value;
    }
}
