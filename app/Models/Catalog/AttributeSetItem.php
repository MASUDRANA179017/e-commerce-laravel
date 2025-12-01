<?php

namespace App\Models\Catalog;

use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeSet;
use App\Models\Catalog\AttributeTerm;
use Illuminate\Database\Eloquent\Model;

class AttributeSetItem extends Model
{
    //
    protected $fillable = [
        'attribute_set_id','category_id','attribute_id','attribute_term_id','is_variant','is_filter','sort_order'
    ];

    protected $casts = [
        'is_variant'    => 'bool',
        'is_filter' => 'bool',
    ];

    public function set()
    {
        return $this->belongsTo(AttributeSet::class, 'attribute_set_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function term()
    {
        return $this->belongsTo(AttributeTerm::class, 'attribute_term_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
