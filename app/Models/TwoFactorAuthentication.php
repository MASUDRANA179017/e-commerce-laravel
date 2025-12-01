<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorAuthentication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sms_auth',
        'email_auth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
