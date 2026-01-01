<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'zipcode',
        'note',
        'total_spent',
        'is_active',
        'password',
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'password',
    ];
}
