<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'email',
        'division',
        'district',
        'upazila',
        'postal_code',
        'address',
        'payment_method',
        'payment_status',
        'subtotal',
        'shipping_charge',
        'discount',
        'grand_total',
        'total',
        'status',
        'notes',
        'ordered_at',
        'invoice_no',
        'status_timeline',
    ];

    protected function casts(): array
    {
        return [
            'ordered_at'      => 'datetime',
            'status_timeline' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
