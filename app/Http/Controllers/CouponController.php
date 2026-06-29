<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Services\CartService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        $coupon = Coupon::where('code', $validated['code'])->first();

        if (! $coupon || ! $coupon->isValid()) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        $cart = app(CartService::class);
        $subtotal = $cart->getTotal();

        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return back()->with('error', 'Minimum order amount of $'.number_format($coupon->min_order_amount, 2).' required.');
        }

        $discount = $coupon->apply($subtotal);
        session(['coupon' => ['code' => $coupon->code, 'discount' => $discount]]);

        return back()->with('success', 'Coupon applied! You saved $'.number_format($discount, 2));
    }

    public function remove()
    {
        session()->forget('coupon');

        return back()->with('success', 'Coupon removed.');
    }
}
