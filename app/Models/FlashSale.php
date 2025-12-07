<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    protected $fillable = [
        'title',
        'description',
        'banner_image',
        'start_time',
        'end_time',
        'discount_percent',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'discount_percent' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * Products in this flash sale
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'flash_sale_products')
            ->withPivot(['flash_price', 'flash_discount_percent', 'stock_limit', 'sold_count'])
            ->withTimestamps();
    }

    /**
     * Scope: Active flash sales
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('status', 'active')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now);
    }

    /**
     * Scope: Featured flash sale
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Upcoming flash sales
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now())
            ->whereIn('status', ['scheduled', 'draft']);
    }

    /**
     * Check if flash sale is currently active
     */
    public function getIsActiveAttribute()
    {
        $now = now();
        return $this->status === 'active' 
            && $this->start_time <= $now 
            && $this->end_time >= $now;
    }

    /**
     * Check if flash sale has ended
     */
    public function getHasEndedAttribute()
    {
        return $this->end_time < now();
    }

    /**
     * Get time remaining in seconds
     */
    public function getTimeRemainingAttribute()
    {
        if ($this->has_ended) {
            return 0;
        }
        return max(0, $this->end_time->diffInSeconds(now()));
    }

    /**
     * Get the current active flash sale (featured first)
     */
    public static function getCurrentActive()
    {
        return static::active()
            ->orderByDesc('is_featured')
            ->orderBy('end_time')
            ->first();
    }

    /**
     * Auto-update status based on time
     */
    public function updateStatusBasedOnTime()
    {
        $now = now();
        
        if ($this->status === 'scheduled' && $this->start_time <= $now) {
            $this->status = 'active';
            $this->save();
        }
        
        if ($this->status === 'active' && $this->end_time < $now) {
            $this->status = 'ended';
            $this->save();
        }
    }
}

