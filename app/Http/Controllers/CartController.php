<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $cartItems = $this->cart->getCart();
        $total = $this->cart->getTotal();
        $count = $this->cart->getCount();

        return view('cart.index', compact('cartItems', 'total', 'count'));
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with('category')->findOrFail($id);

        if (!$product->status) {
            return back()->with('error', 'This product is unavailable.');
        }

        $quantity = min($request->quantity, $product->stock);
        $this->cart->add($product, $quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $quantity = min($request->quantity, $product->stock);
        $this->cart->update($id, $quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $this->cart->remove($id);
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $this->cart->clear();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
