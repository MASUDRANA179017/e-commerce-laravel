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
}
