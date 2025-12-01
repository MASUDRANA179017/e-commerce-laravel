<?php

namespace App\Models;

use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeTerm;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeTerm extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id','attribute_id','term_id'];

    public function product()   { return $this->belongsTo(Product::class); }
    public function attribute() { return $this->belongsTo(Attribute::class); }
    public function term()      { return $this->belongsTo(AttributeTerm::class, 'term_id'); }


}
