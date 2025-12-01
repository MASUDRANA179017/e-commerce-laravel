<?php

namespace App\Models\Admin\Business_SetUp;

use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    protected $fillable = [
        'prefix_name',
        'prefix_style',
        'prefix_format',
        'prefix_code',
        'separators',
        'digit_limit',
    ];
}
