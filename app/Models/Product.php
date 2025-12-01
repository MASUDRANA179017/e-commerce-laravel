<?php

namespace App\Models;

use App\Models\Admin\Brand\Brand;
use App\Models\Admin\Product\ProductCategory;
use App\Models\Catalog\AttributeSet;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
        return ($this->sale_price && $this->sale_price < $this->price) 
            ? $this->sale_price 
            : $this->price;
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
    public function variantRule()   { return $this->belongsTo(VariantRule::class); }

    public function categories() {
        return $this->belongsToMany(ProductCategory::class, 'product_category_map', 'product_id', 'category_id')
            ->withPivot('is_primary');
    }

    public function images()        { return $this->hasMany(ProductImage::class); }
    public function coverImage()    { return $this->hasOne(ProductImage::class)->where('is_cover',true); }

    public function attributeTerms(){ return $this->hasMany(ProductAttributeTerm::class); }

    public function variants()      { return $this->hasMany(ProductVariant::class); }
}
