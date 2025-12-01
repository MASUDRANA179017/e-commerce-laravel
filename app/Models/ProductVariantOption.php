<?php

namespace App\Models;

use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeTerm;
use Illuminate\Database\Eloquent\Model;

class ProductVariantOption extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['variant_id','attribute_id','term_id'];

    public function variant()   { return $this->belongsTo(ProductVariant::class); }
    public function attribute() { return $this->belongsTo(Attribute::class); }
    public function term()      { return $this->belongsTo(AttributeTerm::class, 'term_id'); }

}
