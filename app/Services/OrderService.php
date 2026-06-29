<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    const STATUSES = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'];

    const PAYMENT_STATUSES = ['pending', 'paid', 'failed', 'refunded'];

    public function getStatuses(): array
    {
        return self::STATUSES;
    }

    public function getPaymentStatuses(): array
    {
        return self::PAYMENT_STATUSES;
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);

        return $order;
    }

    public function updatePaymentStatus(Order $order, string $paymentStatus): Order
    {
        $order->update(['payment_status' => $paymentStatus]);

        return $order;
    }

    public function getRevenue(): float
    {
        return Order::where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->sum('grand_total');
    }

    public function getMonthlyRevenue(int $year, int $month): float
    {
        return Order::where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->whereYear('ordered_at', $year)
            ->whereMonth('ordered_at', $month)
            ->sum('grand_total');
    }

    public function getOrderTotalsByStatus(): array
    {
        return [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
    }

    public function search(string $query, ?int $perPage = 15)
    {
        return Order::where('id', 'LIKE', "%{$query}%")
            ->orWhere('customer_name', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate($perPage);
    }
}
