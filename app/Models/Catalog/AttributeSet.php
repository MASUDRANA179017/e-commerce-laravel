<?php

namespace App\Models\Catalog;

use App\Models\Catalog\AttributeSetItem;
use Illuminate\Database\Eloquent\Model;

class AttributeSet extends Model
{
    protected $fillable = ['name', 'category_id', 'created_by'];

    public function items()
    {
        return $this->hasMany(AttributeSetItem::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
