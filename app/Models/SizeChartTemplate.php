<?php

namespace App\Models;

use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Model;

class SizeChartTemplate extends Model
{
    //
      protected $fillable = ['category_id','code','name','unit','columns','rows','notes','image_path','is_active'];
  protected $casts = ['columns'=>'array','rows'=>'array','is_active'=>'boolean'];
  public function category(){ return $this->belongsTo(Category::class); }
}
