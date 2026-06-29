<?php

namespace App\Services;

use App\Models\Product;

class InventoryService
{
    public function getLowStockCount(int $threshold = 5): int
    {
        return Product::lowStock($threshold)->count();
    }

    public function getOutOfStockCount(): int
    {
        return Product::outOfStock()->count();
    }

    public function getLowStockProducts(int $threshold = 5, int $limit = 10)
    {
        return Product::with('category')
            ->lowStock($threshold)
            ->orderBy('stock')
            ->limit($limit)
            ->get();
    }

    public function getTotalStockValue(): float
    {
        return Product::where('status', true)->get()->sum(function ($product) {
            return $product->stock * ($product->discount_price ?: $product->price);
        });
    }

    public function getTopSellingProducts(int $limit = 10)
    {
        return Product::withCount(['orderItems as total_sold' => function ($q) {
            $q->select(\DB::raw('COALESCE(SUM(quantity), 0)'));
        }])
            ->groupBy('products.id')
            ->having('total_sold', '>', 0)
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
}
