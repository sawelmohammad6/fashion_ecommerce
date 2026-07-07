<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->get('per_page'), [10, 25, 50, 100]) ? (int) $request->get('per_page') : 10;

        $customers = $query->withCount('orders')
            ->addSelect(['spent' => Order::selectRaw('COALESCE(SUM(grand_total), 0)')
                ->whereColumn('user_id', 'users.id')
                ->whereIn('status', ['delivered', 'completed'])
            ])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->loadCount([
            'orders as total_orders',
            'orders as completed_orders' => fn ($q) => $q->where('status', 'delivered'),
            'orders as pending_orders' => fn ($q) => $q->where('status', 'pending'),
            'orders as cancelled_orders' => fn ($q) => $q->where('status', 'cancelled'),
            'wishlists as wishlist_count',
        ]);

        $recentOrders = $customer->orders()
            ->withCount('items')
            ->latest()
            ->limit(5)
            ->get();

        $recentWishlists = $customer->wishlists()
            ->with('product')
            ->latest()
            ->limit(5)
            ->get();

        $totalSpent = $customer->totalSpent();

        return view('admin.customers.show', compact(
            'customer',
            'recentOrders',
            'recentWishlists',
            'totalSpent',
        ));
    }
}
