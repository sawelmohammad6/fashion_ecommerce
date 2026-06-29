<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->withCount('orders')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->load(['orders' => function ($q) {
            $q->latest()->limit(10);
        }]);

        $orderCount = $customer->orders()->count();
        $totalSpent = $customer->orders()->where('status', 'delivered')->sum('grand_total');

        return view('admin.customers.show', compact('customer', 'orderCount', 'totalSpent'));
    }
}
