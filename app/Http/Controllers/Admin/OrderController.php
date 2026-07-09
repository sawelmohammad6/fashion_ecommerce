<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::withCount('items');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('invoice_no', 'LIKE', "%{$search}%")
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

        if ($paymentMethod = $request->get('payment_method')) {
            $query->where('payment_method', $paymentMethod);
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('ordered_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('ordered_at', '<=', $dateTo);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'oldest'        => $query->oldest('ordered_at'),
            'highest'       => $query->orderByDesc('grand_total'),
            'lowest'        => $query->orderBy('grand_total'),
            default         => $query->latest('ordered_at'),
        };

        $orders = $query->paginate(15)->withQueryString();

        $totalOrders     = Order::count();
        $pendingOrders   = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::whereIn('status', ['cancelled', 'returned'])->count();
        $todayOrders     = Order::whereDate('ordered_at', today())->count();
        $todayRevenue    = Order::whereIn('status', ['delivered', 'completed'])
            ->whereDate('ordered_at', today())
            ->sum('grand_total');

        $statuses        = $this->orderService->getStatuses();
        $paymentStatuses = $this->orderService->getPaymentStatuses();
        $paymentMethods  = $this->orderService->getPaymentMethods();

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'deliveredOrders',
            'cancelledOrders',
            'todayOrders',
            'todayRevenue',
            'statuses',
            'paymentStatuses',
            'paymentMethods',
        ));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');

        $statuses = $this->orderService->getStatuses();
        $paymentStatuses = $this->orderService->getPaymentStatuses();

        return view('admin.orders.show', compact('order', 'statuses', 'paymentStatuses'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();

        if (isset($data['status']) && $data['status'] !== $order->status) {
            $this->orderService->updateStatus($order, $data['status']);
        }

        if (isset($data['payment_status']) && $data['payment_status'] !== $order->payment_status) {
            $this->orderService->updatePaymentStatus($order, $data['payment_status']);
        }

        $order->refresh();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function invoice(Order $order)
    {
        $order->load('items.product');

        return view('admin.orders.invoice', compact('order'));
    }

    public function exportCsv()
    {
        $orders = Order::withCount('items')->latest('ordered_at')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="orders-export-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Order ID', 'Invoice No', 'Customer Name', 'Phone', 'Email',
                'Subtotal', 'Discount', 'Coupon Code', 'Tax', 'Shipping', 'Grand Total',
                'Payment Method', 'Payment Status', 'Transaction ID', 'Order Status',
                'Items Count', 'Order Date',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->invoice_no ?? 'N/A',
                    $order->customer_name,
                    $order->phone,
                    $order->email,
                    $order->subtotal,
                    $order->discount,
                    $order->coupon_code ?? '',
                    $order->tax,
                    $order->shipping_charge,
                    $order->grand_total,
                    $order->payment_method,
                    $order->payment_status,
                    $order->transaction_id ?? '',
                    $order->status,
                    $order->items_count,
                    $order->ordered_at?->format('Y-m-d H:i') ?? $order->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel()
    {
        $orders = Order::withCount('items')->latest('ordered_at')->get();

        $rows = collect($orders)->map(fn ($order) => [
            $order->id,
            $order->invoice_no ?? 'N/A',
            $order->customer_name,
            $order->phone,
            $order->email,
            $order->subtotal,
            $order->discount,
            $order->coupon_code ?? '',
            $order->tax,
            $order->shipping_charge,
            $order->grand_total,
            $order->payment_method,
            $order->payment_status,
            $order->transaction_id ?? '',
            $order->status,
            $order->items_count,
            $order->ordered_at?->format('Y-m-d H:i') ?? $order->created_at->format('Y-m-d H:i'),
        ]);

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="orders-export-' . now()->format('Y-m-d') . '.xls.csv"',
        ];

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Order ID', 'Invoice No', 'Customer Name', 'Phone', 'Email',
                'Subtotal', 'Discount', 'Coupon Code', 'Tax', 'Shipping', 'Grand Total',
                'Payment Method', 'Payment Status', 'Transaction ID', 'Order Status',
                'Items Count', 'Order Date',
            ]);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function statuses(Order $order)
    {
        $statuses = $this->orderService->getStatuses();

        return response()->json([
            'statuses' => $statuses,
            'current'  => $order->status,
            'timeline' => $order->status_timeline ?? [],
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', $this->orderService->getStatuses())],
        ]);

        $this->orderService->updateStatus($order, $request->status);

        return response()->json([
            'success'   => true,
            'message'   => 'Order status updated to ' . ucfirst($request->status) . '.',
            'status'    => $order->fresh()->status,
            'timeline'  => $order->fresh()->status_timeline,
        ]);
    }

    public function pdf(Order $order)
    {
        $order->load('items.product');

        $pdf = Pdf::loadView('admin.orders.pdf', compact('order'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('invoice-' . ($order->invoice_no ?? $order->id) . '.pdf');
    }
}
