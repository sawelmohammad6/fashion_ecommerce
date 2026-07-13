<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference',
        'reason',
        'remarks',
        'supplier',
        'purchase_price',
        'performed_by',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'purchase_price' => 'decimal:2',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
