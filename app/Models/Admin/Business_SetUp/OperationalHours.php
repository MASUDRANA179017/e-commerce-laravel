<?php

namespace App\Models\Admin\Business_SetUp;

use Illuminate\Database\Eloquent\Model;

class OperationalHours extends Model
{
    protected $fillable = [
        'day',
        'status',
        'start_time',
        'end_time',
        'updated_by',
    ];
}
