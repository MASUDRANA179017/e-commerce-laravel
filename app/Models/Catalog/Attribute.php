<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model {
    protected $fillable = ['slug','name','code','type','edit_fields'];
    protected $casts   = ['edit_fields' => 'array'];

    public function terms() {
        return $this->hasMany(AttributeTerm::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_attribute');
    }
}
