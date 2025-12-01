<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_frequency',
        'quiet_hours',
        'notification_channels',
        'priority_level',
        'notification_sound',
    ];

    protected $casts = [
        'notification_channels' => 'array', 
    ];

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
