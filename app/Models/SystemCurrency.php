<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SystemCurrency extends Model
{
    protected $table = 'system_currencies';

    protected $fillable = [
        'default_currency',
        'fiscal_year_start',
        'usd_to_bdt_rate',
        'updated_by',
    ];

    protected $casts = [
        'usd_to_bdt_rate' => 'decimal:6',
    ];

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Convenience singleton accessor
    public static function instance(): self
    {
        return static::firstOrCreate(
            ['singleton' => true],
            [
                'default_currency'  => 'BDT',
                'fiscal_year_start' => 'July',
                'usd_to_bdt_rate'   => 118.50,
            ]
        );
    }
}