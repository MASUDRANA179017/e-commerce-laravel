<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantSet extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'attribute_set_id',
        'sku_prefix',
        'media_rules',
        'variant_rules',
        'variants',
        'status',
        'created_by',
    ];

    protected $casts = [
        'media_rules' => 'array',
        'variant_rules' => 'array',
        'variants' => 'array',
    ];

    public function businessCategory()
    {
        return $this->belongsTo(\App\Models\Catalog\Category::class, 'category_id');
    }

    public function attributeSet()
    {
        return $this->belongsTo(\App\Models\Catalog\AttributeSet::class, 'attribute_set_id');
    }

    public function getVariantsCountAttribute()
    {
        return is_array($this->variants) ? count($this->variants) : 0;
    }
}
