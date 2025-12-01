<?php

namespace App\Models;

use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model {
  protected $fillable = ['category_id','name','unit','columns','rows','notes','image_path','created_by'];
  protected $casts = ['columns'=>'array','rows'=>'array'];
  public function category(){ return $this->belongsTo(Category::class); }
}