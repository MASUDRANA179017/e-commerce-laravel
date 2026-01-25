<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductVariant extends Model
{
    protected $fillable = ['product_id','sku','combination_key','active','stock_quantity','price'];
    protected $casts = ['active'=>'boolean','stock_quantity'=>'integer','price'=>'decimal:2'];

    public function product()  { return $this->belongsTo(Product::class); }
    public function options()  { return $this->hasMany(ProductVariantOption::class, 'variant_id'); }
    public function images()   { return $this->hasMany(ProductVariantImage::class, 'variant_id'); }

    /**
     * Get purchase sell price from latest received purchase
     */
    public function getPurchaseSellPriceAttribute()
    {
        return DB::table('purchase_items')
            ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
            ->where('purchase_items.variant_id', $this->id)
            ->where('purchases.status', 'received')
            ->orderByDesc('purchases.purchase_date')
            ->value('purchase_items.sell_price');
    }

    /**
     * Get the effective price for this variant
     */
    public function getEffectivePriceAttribute()
    {
        if ($this->price !== null && $this->price > 0) {
            return $this->price;
        }

        $purchasePrice = $this->purchase_sell_price;
        if ($purchasePrice !== null && $purchasePrice > 0) {
            return $purchasePrice;
        }

        return $this->product->effective_price;
    }

    /**
     * Get purchase cost for this variant
     */
    public function getPurchaseCostAttribute()
    {
        $lastPurchase = PurchaseItem::where('product_id', $this->product_id)
            ->where('variant_id', $this->id)
            ->orderByDesc('created_at')
            ->first();
        
        return $lastPurchase ? $lastPurchase->unit_cost : ($this->price ?? $this->product->price);
    }

    /**
     * Get stock status for this variant
     */
    public function getIsInStockAttribute()
    {
        return $this->stock_quantity > 0 || $this->product->allow_backorder;
    }

    /**
     * Get variant name from combination
     */
    public function getVariantNameAttribute()
    {
        $optionNames = $this->options()
            ->with('attributeTerm')
            ->get()
            ->pluck('attributeTerm.name')
            ->toArray();

        return !empty($optionNames) ? implode(', ', $optionNames) : 'Variant';
    }

    public static function buildCombinationKey(array $pairs): string
    {
        // $pairs: [['attribute_id'=>1,'term_id'=>2], ...] or [['1','2'],['4','10']]
        $norm = array_map(function($p){
            if (is_array($p) && Arr::isAssoc($p)) return $p['attribute_id'].':'.$p['term_id'];
            return (string)$p[0].':'.$p[1];
        }, $pairs);
        sort($norm, SORT_NATURAL);
        return implode('|', $norm);
    }

}
