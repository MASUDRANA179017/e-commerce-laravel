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
        'title','slug','short_desc','status',
        'featured','allow_backorder','variant_wise_image',
        'seo_title','seo_desc','seo_keys',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'allow_backorder' => 'boolean',
        'variant_wise_image' => 'boolean',
    ];

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
