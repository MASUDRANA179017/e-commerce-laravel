<?php

namespace App\Models\Catalog;

use App\Models\Catalog\Attribute;
use Illuminate\Database\Eloquent\Model;


//
class Category extends Model
{
    protected $fillable = ['slug', 'name'];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'category_attribute');
    }
}
