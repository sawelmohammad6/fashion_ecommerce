<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\InventoryService;
use App\Services\OrderService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(InventoryService $inventory, OrderService $orderService)
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalCustomers = User::where('is_admin', false)->count();
        $revenue = $orderService->getRevenue();
        $todayRevenue = Order::where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->whereDate('ordered_at', today())
            ->sum('grand_total');
        $lowStockCount = $inventory->getLowStockCount();
        $lowStockProducts = $inventory->getLowStockProducts(5, 10);
        $recentOrders = Order::with('user')->latest()->limit(8)->get();
        $latestCustomers = User::where('is_admin', false)->latest()->limit(8)->get();

        $topProducts = $inventory->getTopSellingProducts(5);
        $latestProducts = Product::latest()->limit(5)->get();
        $orderTotals = $orderService->getOrderTotalsByStatus();

        $months = collect();
        $monthlyRevenue = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));
            $monthlyRevenue->push(Order::where('status', 'delivered')
                ->where('payment_status', 'paid')
                ->whereYear('ordered_at', $date->year)
                ->whereMonth('ordered_at', $date->month)
                ->sum('grand_total'));
        }

        $weeklySales = collect();
        $weekLabels = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weekLabels->push($date->format('D'));
            $weeklySales->push(Order::where('status', 'delivered')
                ->whereDate('ordered_at', $date)
                ->sum('grand_total'));
        }

        return view('admin.dashboard.index', compact(
            'totalProducts', 'totalCategories', 'totalOrders',
            'pendingOrders', 'deliveredOrders', 'cancelledOrders',
            'totalCustomers', 'revenue', 'todayRevenue',
            'lowStockCount', 'lowStockProducts',
            'recentOrders', 'latestCustomers',
            'topProducts', 'latestProducts', 'orderTotals',
            'months', 'monthlyRevenue', 'weekLabels', 'weeklySales'
        ));
    }
}
