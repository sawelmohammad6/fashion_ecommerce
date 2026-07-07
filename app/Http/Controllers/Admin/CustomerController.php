<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $query->withCount('orders')
            ->addSelect(['spent' => Order::selectRaw('COALESCE(SUM(grand_total), 0)')
                ->whereColumn('user_id', 'users.id')
                ->whereIn('status', ['delivered', 'completed'])
            ]);

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'alphabetical' => $query->orderBy('name', 'asc'),
            'most_orders' => $query->orderBy('orders_count', 'desc'),
            'highest_spending' => $query->orderBy('spent', 'desc'),
            default => $query->latest(),
        };

        $perPage = in_array((int) $request->get('per_page'), [10, 25, 50, 100]) ? (int) $request->get('per_page') : 10;

        $customers = $query->paginate($perPage)->withQueryString();

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
            'orders as returned_orders' => fn ($q) => $q->where('status', 'returned'),
            'wishlists as wishlist_count',
        ]);

        $orders = $customer->orders()
            ->withCount('items')
            ->latest()
            ->get();

        $recentWishlists = $customer->wishlists()
            ->with('product')
            ->latest()
            ->limit(5)
            ->get();

        $totalSpent = $customer->totalSpent();
        $averageOrderValue = $customer->total_orders > 0
            ? $totalSpent / $customer->total_orders
            : 0;

        $monthlySpending = $orders
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(fn ($o) => $o->created_at->format('Y-m'))
            ->map(fn ($group) => $group->sum('grand_total'))
            ->sortKeys();

        return view('admin.customers.show', compact(
            'customer',
            'orders',
            'recentWishlists',
            'totalSpent',
            'averageOrderValue',
            'monthlySpending',
        ));
    }

    public function edit(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:50|unique:users,username,' . $customer->id,
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,pending,blocked',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function block(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->update(['status' => 'blocked']);

        return redirect()->back()->with('success', 'Customer has been blocked.');
    }

    public function unblock(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Customer has been unblocked.');
    }

    public function activate(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Customer has been activated.');
    }

    public function deactivate(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->update(['status' => 'pending']);

        return redirect()->back()->with('success', 'Customer has been deactivated.');
    }

    public function destroy(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function exportCsv(Request $request)
    {
        $query = $this->buildFilteredQuery($request);
        $query->withCount('orders')
            ->addSelect(['spent' => Order::selectRaw('COALESCE(SUM(grand_total), 0)')
                ->whereColumn('user_id', 'users.id')
                ->whereIn('status', ['delivered', 'completed'])
            ]);

        $fileName = 'customers-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['ID', 'Name', 'Username', 'Email', 'Phone', 'Gender', 'Country', 'City', 'Status', 'Verified', 'Registered', 'Total Orders', 'Total Spent']);

            $query->chunk(200, function ($customers) use ($handle) {
                foreach ($customers as $customer) {
                    fputcsv($handle, [
                        $customer->id,
                        $customer->name,
                        $customer->username,
                        $customer->email,
                        $customer->phone,
                        $customer->gender,
                        $customer->country,
                        $customer->city,
                        $customer->status,
                        $customer->email_verified_at ? 'Yes' : 'No',
                        $customer->created_at->format('Y-m-d'),
                        $customer->orders_count,
                        number_format($customer->spent ?? 0, 2),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    public function exportExcel(Request $request)
    {
        $query = $this->buildFilteredQuery($request);
        $query->withCount('orders')
            ->addSelect(['spent' => Order::selectRaw('COALESCE(SUM(grand_total), 0)')
                ->whereColumn('user_id', 'users.id')
                ->whereIn('status', ['delivered', 'completed'])
            ]);

        $fileName = 'customers-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new CustomersExport($query), $fileName);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
            'action' => 'required|in:block,activate,delete',
        ]);

        $customers = User::whereIn('id', $request->ids)->where('is_admin', false)->get();

        if ($customers->isEmpty()) {
            return redirect()->back()->with('error', 'No valid customers selected.');
        }

        $action = $request->action;
        $count = 0;

        foreach ($customers as $customer) {
            match ($action) {
                'block' => $customer->update(['status' => 'blocked']),
                'activate' => $customer->update(['status' => 'active']),
                'delete' => $customer->delete(),
            };
            $count++;
        }

        $actionLabel = match ($action) {
            'block' => 'blocked',
            'activate' => 'activated',
            'delete' => 'deleted',
        };

        return redirect()->back()->with('success', "{$count} customer(s) {$actionLabel} successfully.");
    }

    private function buildFilteredQuery(Request $request)
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

        if ($status = $request->get('status')) {
            if (in_array($status, ['active', 'pending', 'blocked'])) {
                $query->where('status', $status);
            }
        }

        if ($verified = $request->get('verified')) {
            if ($verified === 'yes') {
                $query->whereNotNull('email_verified_at');
            } elseif ($verified === 'no') {
                $query->whereNull('email_verified_at');
            }
        }

        if ($gender = $request->get('gender')) {
            if (in_array($gender, ['male', 'female', 'other'])) {
                $query->where('gender', $gender);
            }
        }

        if ($country = $request->get('country')) {
            $query->where('country', 'LIKE', "%{$country}%");
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        return $query;
    }
}
