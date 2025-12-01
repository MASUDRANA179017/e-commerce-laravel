<?php

namespace App\Models\Admin\Brand;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'website',
        'country',
        'order',
        'logo',
        'description',
        'featured',
        'active',
        'top',
    ];
}
