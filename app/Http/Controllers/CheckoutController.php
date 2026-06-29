<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Mail\OrderPlaced;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->middleware('auth');
        $this->cart = $cart;
    }

    public function create()
    {
        $cartItems = $this->cart->getCart();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cart->getTotal();
        $shippingCharge = $subtotal >= 100 ? 0 : 9.99;
        $discount = session('coupon.discount', 0);
        $grandTotal = max(0, $subtotal + $shippingCharge - $discount);
        $count = $this->cart->getCount();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCharge', 'discount', 'grandTotal', 'count'));
    }

    public function store(StoreOrderRequest $request)
    {
        $cartItems = $this->cart->getCart();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cart->getTotal();
        $shippingCharge = $subtotal >= 100 ? 0 : 9.99;
        $discount = session('coupon.discount', 0);
        $grandTotal = max(0, $subtotal + $shippingCharge - $discount);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'division' => $request->division,
                'district' => $request->district,
                'upazila' => $request->upazila,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_charge' => $shippingCharge,
                'discount' => $discount,
                'grand_total' => $grandTotal,
                'total' => $grandTotal,
                'status' => 'pending',
                'notes' => $request->notes,
                'ordered_at' => now(),
            ]);

            foreach ($cartItems as $id => $item) {
                $product = Product::findOrFail($id);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}.");
                }

                $order->items()->create([
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            if ($couponCode = session('coupon.code')) {
                Coupon::where('code', $couponCode)->increment('used_count');
            }

            DB::commit();

            try {
                Mail::to($order->email)->send(new OrderPlaced($order));
            } catch (\Exception $e) {
                // Silently fail if email cannot be sent
            }

            $this->cart->clear();
            session()->forget('coupon');

            return redirect()->route('orders.success', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
