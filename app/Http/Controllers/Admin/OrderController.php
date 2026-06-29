<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('customer_name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($paymentStatus = $request->get('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('ordered_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('ordered_at', '<=', $dateTo);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $statuses = $this->orderService->getStatuses();
        $paymentStatuses = $this->orderService->getPaymentStatuses();

        return view('admin.orders.index', compact('orders', 'statuses', 'paymentStatuses'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->update($data);

        try {
            Mail::to($order->email)->send(new OrderStatusUpdated($order));
        } catch (\Exception $e) {
            // Silently fail if email cannot be sent
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function invoice(Order $order)
    {
        $order->load('items.product');

        return view('admin.orders.invoice', compact('order'));
    }
}
