<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product.category')->latest()->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $user = auth()->user();
        $existing = $user->wishlists()->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Removed from wishlist.');
        }

        $user->wishlists()->create(['product_id' => $product->id]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function moveToCart(Product $product)
    {
        $cart = session('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min($cart[$id]['quantity'] + 1, $product->stock);
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'category_slug' => $product->category->slug ?? '',
            ];
        }

        session(['cart' => $cart]);

        auth()->user()->wishlists()->where('product_id', $id)->delete();

        return redirect()->route('cart.index')->with('success', 'Product moved to cart.');
    }

    public function destroy(Product $product)
    {
        auth()->user()->wishlists()->where('product_id', $product->id)->delete();

        return back()->with('success', 'Removed from wishlist.');
    }
}
