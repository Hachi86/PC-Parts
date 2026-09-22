@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<h2 style="font-family:'Rajdhani',sans-serif;font-size:1.5rem;margin-bottom:1.5rem">All Orders</h2>

<div class="card mb-2" style="margin-bottom:1.25rem">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap">
            <div style="flex:1;min-width:200px">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Order # or customer name..." value="{{ request('search') }}">
            </div>
            <div style="min-width:140px">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    @foreach(\App\Models\Order::statuses() as $s)
                        <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i class="fas fa-undo"></i></a>
        </form>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr><th>Order #</th><th>Customer</th><th>Date</th><th>Items</th><th>Total</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-weight:600;color:var(--accent)">{{ $order->order_number }}</td>
                <td>
                    <p style="font-size:.875rem">{{ $order->user->name ?? '—' }}</p>
                    <p style="font-size:.75rem;color:var(--muted)">{{ $order->shipping_email }}</p>
                </td>
                <td style="font-size:.8rem;color:var(--muted)">{{ $order->created_at->format('M d, Y') }}</td>
                <td style="font-size:.875rem">{{ $order->items->count() }}</td>
                <td style="font-weight:700">${{ number_format($order->total, 2) }}</td>
                <td><span class="badge badge-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:3rem">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:1rem;display:flex;justify-content:center">
        {{ $orders->links() }}
    </div>
</div>
@endsection
