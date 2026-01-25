<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_cost',
        'sell_price',
        'total_cost',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the selling price for this purchase item
     */
    public function getSellPriceAttribute()
    {
        return $this->attributes['sell_price'] ?? $this->unit_cost;
    }
}

