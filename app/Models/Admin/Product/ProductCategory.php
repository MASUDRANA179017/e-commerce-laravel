<?php

namespace App\Models\Admin\Product;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'order',
        'show_on_menu',
        'icon',
        'thumb_url',
    ];
    

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    // Get level of category
    public function level()
    {
        $level = 1;
        $parent = $this->parent;
        while($parent){
            $level++;
            $parent = $parent->parent;
        }
        return $level;
    }

    // Recursive relation (unlimited depth)
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
