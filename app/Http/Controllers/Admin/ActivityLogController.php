<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('module', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'LIKE', "%{$search}%"));
            });
        }

        if ($module = $request->get('module')) {
            $query->where('module', $module);
        }

        if ($userId = $request->get('user_id')) {
            $query->where('user_id', $userId);
        }

        if ($dateFilter = $request->get('date_filter')) {
            match ($dateFilter) {
                'today'     => $query->whereDate('created_at', today()),
                'yesterday' => $query->whereDate('created_at', today()->subDay()),
                'week'      => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'month'     => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                default     => null,
            };
        }

        $logs = $query->paginate(20)->withQueryString();

        $modules = ActivityLog::select('module')->distinct()->pluck('module')->sort()->values();
        $admins  = User::where('is_admin', true)->get(['id', 'name']);

        return view('admin.activity-logs.index', compact('logs', 'modules', 'admins'));
    }

    public function exportCsv(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date_filter')) {
            match ($request->date_filter) {
                'today'     => $query->whereDate('created_at', today()),
                'yesterday' => $query->whereDate('created_at', today()->subDay()),
                'week'      => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'month'     => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                default     => null,
            };
        }

        $logs = $query->get();

        $filename = 'activity-logs-' . now()->format('YmdHis') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Time', 'Admin', 'Module', 'Action', 'Description', 'IP Address']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->created_at->format('Y-m-d'),
                    $log->created_at->format('H:i:s'),
                    $log->user?->name ?? 'System',
                    $log->module,
                    $log->action,
                    $log->description,
                    $log->ip_address ?? '—',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
