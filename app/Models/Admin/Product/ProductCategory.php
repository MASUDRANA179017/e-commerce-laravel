<?php

namespace App\Models\Admin\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'order',
        'show_on_menu',
        'icon',
        'thumb_url',
        'image',
        'description',
    ];
    
    /**
     * Get the products for this category
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category_map', 'category_id', 'product_id')
            ->withPivot('is_primary');
    }

    /**
     * Get only active products count
     */
    public function activeProducts()
    {
        return $this->products()->where('status', 'Active');
    }

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

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Str::slug($category->name);
            }
        });
    }
}
