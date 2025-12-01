<?php

namespace App\Models\Catalog;

use App\Models\Catalog\Attribute;
use Illuminate\Database\Eloquent\Model;

class AttributeTerm extends Model {
    protected $fillable = ['attribute_id','slug','name','code','unit','color','has_border','meta'];
    protected $casts = ['has_border' => 'boolean', 'meta' => 'array'];

    public function attribute() {
        return $this->belongsTo(Attribute::class);
    }
}

