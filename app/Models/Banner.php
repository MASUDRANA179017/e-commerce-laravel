<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link',
        'type',
        'theme',
        'position',
        'status',
        'clicks',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
