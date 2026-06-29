<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount',
        'usage_limit', 'used_count', 'expiry_date', 'status',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'expiry_date' => 'date',
            'status' => 'boolean',
        ];
    }

    public function isValid(): bool
    {
        if (! $this->status) {
            return false;
        }
        if ($this->expiry_date && Carbon::parse($this->expiry_date)->isPast()) {
            return false;
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function apply(float $subtotal): float
    {
        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return 0;
        }

        return $this->type === 'percentage'
            ? round($subtotal * $this->value / 100, 2)
            : min($this->value, $subtotal);
    }
}
