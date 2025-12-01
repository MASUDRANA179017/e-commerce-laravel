<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'special_id',
        'email',
        'attachment',
        'description',
    ];
}
