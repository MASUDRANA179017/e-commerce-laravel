<?php

namespace App\Models\Admin\Business_SetUp;

use Illuminate\Database\Eloquent\Model;

class OfficeDocument extends Model
{
    protected $fillable = [
        'type',        // 🔹 Add this
        'file_path',   // your file path
        'updated_by',
    ];
}
