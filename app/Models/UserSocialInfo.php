<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'whatsapp',
        'facebook',
        'linkedin',
        'github',
        'portfolio',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
