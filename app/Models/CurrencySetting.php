<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencySetting extends Model
{
    protected $fillable = [
        'currency_name',
        'currency_code',
        'symbol',
        'exchange_rate',
        'is_default',
        'status',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:4',
        'is_default' => 'boolean',
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    protected static function booted(): void
    {
        static::saving(function ($currency) {
            if ($currency->status) {
                static::where('id', '!=', $currency->id)->update(['status' => false]);
            }
            if ($currency->is_default) {
                static::where('id', '!=', $currency->id)->update(['is_default' => false]);
            }
        });
    }
}
