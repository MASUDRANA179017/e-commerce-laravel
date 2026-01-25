<?php

namespace App\Models;

use App\Models\Admin\Brand\Brand;
use App\Models\Admin\Product\ProductCategory;
use App\Models\Catalog\AttributeSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'brand_id','attribute_set_id','variant_rule_id',
        'title','slug','sku','short_desc',
        'price','sale_price','stock_quantity',
        'status','featured','allow_backorder','variant_wise_image',
        'seo_title','seo_desc','seo_keys',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'allow_backorder' => 'boolean',
        'variant_wise_image' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    /**
     * Get the effective price (sale price if available, otherwise regular price)
     */
    public function getEffectivePriceAttribute()
    {
        // 1. Check sale price
        if ($this->sale_price && $this->sale_price < $this->price) {
            return $this->sale_price;
        }

        // 2. Check regular price
        if ($this->price !== null && $this->price > 0) {
            return $this->price;
        }

        // 3. Fallback to purchase price
        return $this->purchase_sell_price ?? 0;
    }

    /**
     * Check if product is on sale
     */
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentAttribute()
    {
        if ($this->is_on_sale && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Check if product is in stock
     */
    public function getInStockAttribute()
    {
        return $this->stock_quantity > 0 || $this->allow_backorder;
    }

    public function brand()         { return $this->belongsTo(Brand::class); }
    public function attributeSet()  { return $this->belongsTo(AttributeSet::class); }
    // public function variantRule()
    // {
    //     return $this->belongsTo(VariantRule::class);
    // }

    public function categories() {
        return $this->belongsToMany(ProductCategory::class, 'product_category_map', 'product_id', 'category_id')
            ->withPivot('is_primary');
    }

    public function images()        { return $this->hasMany(ProductImage::class); }
    public function coverImage()    { return $this->hasOne(ProductImage::class)->where('is_cover',true); }

    public function attributeTerms(){ return $this->hasMany(ProductAttributeTerm::class); }

    public function variants()      { return $this->hasMany(ProductVariant::class); }
    
    public function purchaseItems() { return $this->hasMany(PurchaseItem::class); }

    public function reviews() { return $this->hasMany(ProductReview::class); }
    
    public function approvedReviews() { 
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

    /**
     * Flash sales this product is part of
     */
    public function flashSales()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_products')
            ->withPivot(['flash_price', 'flash_discount_percent', 'stock_limit', 'sold_count'])
            ->withTimestamps();
    }

    /**
     * Get active flash sale for this product
     */
    public function getActiveFlashSaleAttribute()
    {
        return $this->flashSales()
            ->where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();
    }

    /**
     * Get flash sale price if product is in active flash sale
     */
    public function getFlashSalePriceAttribute()
    {
        $flashSale = $this->active_flash_sale;
        return $flashSale ? $flashSale->pivot->flash_price : null;
    }

    /**
     * Get flash sale discount percent
     */
    public function getFlashDiscountPercentAttribute()
    {
        $flashSale = $this->active_flash_sale;
        return $flashSale ? $flashSale->pivot->flash_discount_percent : 0;
    }
    
    public function getAverageRatingAttribute() {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }
    
    public function getReviewsCountAttribute() {
        return $this->approvedReviews()->count();
    }

    /**
     * Get the purchase sell price for the product
     */
    public function getPurchaseSellPriceAttribute()
    {
        return DB::table('purchase_items')
            ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
            ->where('purchase_items.product_id', $this->id)
            ->where('purchases.status', 'received')
            ->orderByDesc('purchases.purchase_date')
            ->value('purchase_items.sell_price');
    }

    /**
     * Get base product price (from purchase or manual price)
     */
    public function getBasePriceAttribute()
    {
        return $this->price ?? $this->purchase_sell_price;
    }

    /**
     * Get price range for product with variants
     */
    public function getPriceRangeAttribute()
    {
        if ($this->variants()->count() === 0) {
            return [
                'min' => $this->effective_price,
                'max' => $this->effective_price,
                'min_sale' => $this->effective_price,
            ];
        }

        $variantPrices = $this->variants()
            ->where('active', true)
            ->get()
            ->map(function($variant) {
                $variant->setRelation('product', $this);
                return $variant->effective_price;
            })
            ->filter() // Filter out nulls/zeros if any, though effective_price handles fallback
            ->toArray();

        if (empty($variantPrices)) {
            return [
                'min' => $this->effective_price,
                'max' => $this->effective_price,
                'min_sale' => $this->effective_price,
            ];
        }

        return [
            'min' => min($variantPrices),
            'max' => max($variantPrices),
            'min_sale' => min($variantPrices),
        ];
    }

    /**
     * Check if product has variants with different prices
     */
    public function getHasVariantPricingAttribute()
    {
        if ($this->variants()->count() === 0) {
            return false;
        }

        $variantPrices = $this->variants()
            ->where('active', true)
            ->get()
            ->map(function($variant) {
                $variant->setRelation('product', $this);
                return (string)$variant->effective_price;
            })
            ->unique()
            ->count();

        return $variantPrices > 1;
    }

    /**
     * Get formatted price range display
     */
    public function getFormattedPriceRangeAttribute()
    {
        $range = $this->price_range;
        
        if ($range['min'] == 0 && $range['max'] == 0) {
            return ''; // Hide if 0
        }

        if ($range['min'] == $range['max']) {
            return '৳' . number_format($range['min'], 0);
        }

        return '৳' . number_format($range['min'], 0) . ' - ৳' . number_format($range['max'], 0);
    }
}
