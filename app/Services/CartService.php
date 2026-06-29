<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    public function getCart(): array
    {
        return session()->get('cart', []);
    }

    public function add(Product $product, int $quantity): void
    {
        $cart = session()->get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min($cart[$id]['quantity'] + $quantity, $product->stock);
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => min($quantity, $product->stock),
                'slug' => $product->slug,
                'stock' => $product->stock,
                'category_slug' => $product->category->slug ?? '',
            ];
        }

        session()->put('cart', $cart);
    }

    public function update(int $id, int $quantity): void
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, min($quantity, $cart[$id]['stock']));
        }
        session()->put('cart', $cart);
    }

    public function remove(int $id): void
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }

    public function getTotal(): float
    {
        $cart = $this->getCart();
        return array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    }

    public function getCount(): int
    {
        return array_sum(array_column($this->getCart(), 'quantity'));
    }
}
