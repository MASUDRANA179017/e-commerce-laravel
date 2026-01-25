<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletters';

    protected $fillable = [
        'email',
        'name',
        'status',
        'subscription_token',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Scope: Get subscribed newsletters
     */
    public function scopeSubscribed($query)
    {
        return $query->where('status', 'subscribed');
    }

    /**
     * Scope: Get unsubscribed newsletters
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('status', 'unsubscribed');
    }

    /**
     * Subscribe an email
     */
    public static function subscribe($email, $name = null)
    {
        return self::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'status' => 'subscribed',
                'subscribed_at' => now(),
                'subscription_token' => str()->random(60),
            ]
        );
    }

    /**
     * Unsubscribe an email
     */
    public function unsubscribe()
    {
        $this->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
        return $this;
    }
}
