<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLocalization extends Model
{
    //
     protected $fillable = [
        'system_language','timezone','default_currency',
        'date_format','time_format','currency_decimals',
        'fiscal_year_start','usd_to_bdt_rate','exchange_rates','updated_by',
    ];

    protected $casts = [
        'exchange_rates' => 'array',
        'usd_to_bdt_rate' => 'decimal:4',
    ];
}
