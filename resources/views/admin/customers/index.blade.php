@extends('layouts.admin')
@section('title', 'Customers')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Customers</h1>
        <p class="text-sm text-gray-400 mt-1">{{ $customers->total() }} registered customers</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.customers.export.csv', request()->query()) }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            CSV
        </a>
        <a href="{{ route('admin.customers.export.excel', request()->query()) }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Excel
        </a>
    </div>
</div>

<form method="GET" class="mb-6">
    <div class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by name, email, phone, or ID..."
               class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition flex-1 min-w-[200px] max-w-sm">
        <select name="status" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
            <option value="" class="bg-gray-900">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }} class="bg-gray-900">Active</option>
            <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }} class="bg-gray-900">Blocked</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }} class="bg-gray-900">Pending</option>
        </select>
        <select name="verified" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
            <option value="" class="bg-gray-900">All Verified</option>
            <option value="yes" {{ request('verified') === 'yes' ? 'selected' : '' }} class="bg-gray-900">Verified</option>
            <option value="no" {{ request('verified') === 'no' ? 'selected' : '' }} class="bg-gray-900">Not Verified</option>
        </select>
        <select name="gender" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
            <option value="" class="bg-gray-900">All Genders</option>
            <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }} class="bg-gray-900">Male</option>
            <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }} class="bg-gray-900">Female</option>
            <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }} class="bg-gray-900">Other</option>
        </select>
        <input type="text" name="country" value="{{ request('country') }}" placeholder="Country"
               class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition w-32">
        <input type="date" name="date_from" value="{{ request('date_from') }}"
               class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition w-36">
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition w-36">
        <button type="submit" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Filter</button>
        @if(request()->hasAny(['search', 'status', 'verified', 'gender', 'country', 'date_from', 'date_to']))
            <a href="{{ route('admin.customers.index', request()->only(['per_page', 'sort'])) }}"
               class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Clear</a>
        @endif
    </div>
</form>

{{-- Sort, Per Page, Bulk Actions — inline row --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="flex items-center gap-3">
        <form method="GET" class="flex items-center gap-2">
            @foreach(request()->except(['sort', 'page']) as $key => $value)
                @if($value !== '' && $value !== null)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <label class="text-sm text-gray-400">Sort</label>
            <select name="sort" onchange="this.form.submit()"
                    class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                <option value="newest" class="bg-gray-900" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" class="bg-gray-900" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="most_orders" class="bg-gray-900" {{ request('sort') === 'most_orders' ? 'selected' : '' }}>Most Orders</option>
                <option value="highest_spending" class="bg-gray-900" {{ request('sort') === 'highest_spending' ? 'selected' : '' }}>Highest Spending</option>
                <option value="alphabetical" class="bg-gray-900" {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>Alphabetical</option>
            </select>
        </form>
        <form method="GET" class="flex items-center gap-2">
            @foreach(request()->except(['per_page', 'page']) as $key => $value)
                @if($value !== '' && $value !== null)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <label class="text-sm text-gray-400">Show</label>
            <select name="per_page" onchange="this.form.submit()"
                    class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition w-20">
                @foreach([10, 25, 50, 100] as $value)
                    <option value="{{ $value }}" class="bg-gray-900" {{ (int) request('per_page', 10) === $value ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="flex items-center gap-2" id="bulk-toolbar">
        <form method="POST" action="{{ route('admin.customers.bulk') }}" id="bulk-form">
            @csrf
            <input type="hidden" name="action" id="bulk-action-input" value="">
            <div class="flex items-center gap-2">
                <label class="flex items-center gap-2 text-sm text-gray-400">
                    <input type="checkbox" id="select-all" class="rounded border-gray-700/50 bg-gray-800/50 text-emerald-500 focus:ring-emerald-500/30">
                    Select All
                </label>
                <button type="button" onclick="confirmBulkAction('block')"
                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 transition disabled:opacity-30 disabled:cursor-not-allowed" disabled id="bulk-block-btn">
                    Block
                </button>
                <button type="button" onclick="confirmBulkAction('activate')"
                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition disabled:opacity-30 disabled:cursor-not-allowed" disabled id="bulk-activate-btn">
                    Activate
                </button>
                <button type="button" onclick="confirmBulkAction('delete')"
                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition disabled:opacity-30 disabled:cursor-not-allowed" disabled id="bulk-delete-btn">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10"></th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Orders</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Spent</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @forelse($customers as $customer)
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="px-4 py-3">
                            <input type="checkbox" value="{{ $customer->id }}"
                                   class="customer-checkbox rounded border-gray-700/50 bg-gray-800/50 text-emerald-500 focus:ring-emerald-500/30"
                                   form="bulk-form" name="ids[]">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white shrink-0">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="font-medium text-gray-300">{{ $customer->name }}</span>
                                    @if($customer->username)
                                        <p class="text-xs text-gray-600">@ {{ $customer->username }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $customer->email }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $customer->phone ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $customer->orders_count }}</td>
                        <td class="px-4 py-3 text-gray-300 font-medium">{{ formatPrice($customer->spent ?? 0) }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statuses = [
                                    'active'  => 'bg-emerald-500/10 text-emerald-400',
                                    'pending' => 'bg-amber-500/10 text-amber-400',
                                    'blocked' => 'bg-red-500/10 text-red-400',
                                ];
                                $class = $statuses[$customer->status] ?? 'bg-gray-500/10 text-gray-400';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $class }}">{{ ucfirst($customer->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-sm">{{ $customer->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.customers.show', $customer) }}"
                                   class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">View</a>
                                <a href="{{ route('admin.customers.edit', $customer) }}"
                                   class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition">Edit</a>
                                @if($customer->status === 'active')
                                    <form method="POST" action="{{ route('admin.customers.block', $customer) }}" class="inline" id="block-form-{{ $customer->id }}">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmAction('block-form-{{ $customer->id }}', 'Block {{ $customer->name }}?', 'They will be unable to login or place orders.', 'Yes, block', '#ef4444')"
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 transition">Block</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.customers.deactivate', $customer) }}" class="inline" id="deactivate-form-{{ $customer->id }}">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmAction('deactivate-form-{{ $customer->id }}', 'Deactivate {{ $customer->name }}?', 'Their account status will be set to pending.', 'Yes, deactivate', '#f59e0b')"
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-500/10 text-gray-400 hover:bg-gray-500/20 transition">Deactivate</button>
                                    </form>
                                @elseif($customer->status === 'blocked')
                                    <form method="POST" action="{{ route('admin.customers.unblock', $customer) }}" class="inline" id="unblock-form-{{ $customer->id }}">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmAction('unblock-form-{{ $customer->id }}', 'Unblock {{ $customer->name }}?', 'They will regain access to their account.', 'Yes, unblock', '#10b981')"
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Unblock</button>
                                    </form>
                                @elseif($customer->status === 'pending')
                                    <form method="POST" action="{{ route('admin.customers.activate', $customer) }}" class="inline" id="activate-form-{{ $customer->id }}">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmAction('activate-form-{{ $customer->id }}', 'Activate {{ $customer->name }}?', 'Their account will become fully active.', 'Yes, activate', '#10b981')"
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Activate</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.customers.block', $customer) }}" class="inline" id="block-pending-form-{{ $customer->id }}">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmAction('block-pending-form-{{ $customer->id }}', 'Block {{ $customer->name }}?', 'They will be unable to login or place orders.', 'Yes, block', '#ef4444')"
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 transition">Block</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline" id="delete-form-{{ $customer->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmAction('delete-form-{{ $customer->id }}', 'Delete {{ $customer->name }}?', 'This will soft-delete the account. It can be restored later.', 'Yes, delete', '#ef4444')"
                                            class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="px-4 py-10 text-center text-gray-500">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($customers->hasPages())
    <div class="mt-4">{{ $customers->links() }}</div>
@endif

@push('scripts')
<script>
function confirmBulkAction(action) {
    var checkboxes = document.querySelectorAll('.customer-checkbox:checked');
    if (checkboxes.length === 0) {
        Swal.fire('No Selection', 'Please select at least one customer.', 'info');
        return;
    }

    var labels = { block: 'blocked', activate: 'activated', delete: 'deleted' };
    var titles = { block: 'Block', activate: 'Activate', delete: 'Delete' };
    var colors = { block: '#ef4444', activate: '#10b981', delete: '#ef4444' };
    var label = labels[action];
    var title = titles[action];
    var color = colors[action];

    Swal.fire({
        title: title + ' ' + checkboxes.length + ' customer(s)?',
        text: action === 'delete'
            ? 'Selected customers will be soft-deleted. They can be restored later.'
            : 'Selected customers will be ' + label + '.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, ' + label,
        cancelButtonText: 'Cancel',
        reverseButtons: true,
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('bulk-action-input').value = action;
            document.getElementById('bulk-form').submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var selectAll = document.getElementById('select-all');
    var checkboxes = document.querySelectorAll('.customer-checkbox');
    var bulkBlockBtn = document.getElementById('bulk-block-btn');
    var bulkActivateBtn = document.getElementById('bulk-activate-btn');
    var bulkDeleteBtn = document.getElementById('bulk-delete-btn');

    function updateBulkButtons() {
        var checked = document.querySelectorAll('.customer-checkbox:checked').length;
        var disabled = checked === 0;
        bulkBlockBtn.disabled = disabled;
        bulkActivateBtn.disabled = disabled;
        bulkDeleteBtn.disabled = disabled;
    }

    selectAll.addEventListener('change', function () {
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
        updateBulkButtons();
    });

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function () {
            if (!this.checked) {
                selectAll.checked = false;
            } else {
                var allChecked = true;
                for (var j = 0; j < checkboxes.length; j++) {
                    if (!checkboxes[j].checked) {
                        allChecked = false;
                        break;
                    }
                }
                selectAll.checked = allChecked;
            }
            updateBulkButtons();
        });
    }

    updateBulkButtons();
});
</script>
@endpush

@endsection
