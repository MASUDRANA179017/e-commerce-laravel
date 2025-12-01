<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    //
    protected $fillable = ['product_id','sku','combination_key','active'];
    protected $casts = ['active'=>'boolean'];

    public function product()  { return $this->belongsTo(Product::class); }
    public function options()  { return $this->hasMany(ProductVariantOption::class, 'variant_id'); }
    public function images()   { return $this->hasMany(ProductVariantImage::class, 'variant_id'); }

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
