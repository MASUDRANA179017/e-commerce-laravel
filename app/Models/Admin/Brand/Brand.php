<?php

namespace App\Models\Admin\Brand;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
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
