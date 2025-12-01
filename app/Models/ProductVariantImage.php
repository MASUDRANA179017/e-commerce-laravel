<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantImage extends Model
{
    protected $fillable = ['variant_id','path'];

    public function variant() { return $this->belongsTo(ProductVariant::class); }
}
