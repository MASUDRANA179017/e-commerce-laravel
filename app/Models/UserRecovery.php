<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecovery extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'recovery_email',
        'recovery_phone',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
