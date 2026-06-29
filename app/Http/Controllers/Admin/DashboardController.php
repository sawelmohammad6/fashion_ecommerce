<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\InventoryService;
use App\Services\OrderService;

class DashboardController extends Controller
{
    public function index(InventoryService $inventory, OrderService $orderService)
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $totalCustomers = User::where('is_admin', false)->count();
        $revenue = $orderService->getRevenue();
        $lowStockCount = $inventory->getLowStockCount();
        $lowStockProducts = $inventory->getLowStockProducts(5, 10);
        $recentOrders = Order::with('user')->latest()->limit(10)->get();
        $latestCustomers = User::where('is_admin', false)->latest()->limit(10)->get();

        return view('admin.dashboard.index', compact(
            'totalProducts', 'totalCategories', 'totalOrders',
            'pendingOrders', 'deliveredOrders', 'totalCustomers',
            'revenue', 'lowStockCount', 'lowStockProducts',
            'recentOrders', 'latestCustomers'
        ));
    }
}
