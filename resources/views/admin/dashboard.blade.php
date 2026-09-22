@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<!-- Stats -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="icon" style="background:rgba(0,212,255,.1);color:var(--accent)"><i class="fas fa-shopping-bag"></i></div>
        <div class="value">{{ number_format($stats['total_orders']) }}</div>
        <div class="label">Total Orders</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(34,197,94,.1);color:var(--success)"><i class="fas fa-dollar-sign"></i></div>
        <div class="value" style="color:var(--success)">${{ number_format($stats['total_revenue'], 0) }}</div>
        <div class="label">Total Revenue</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(124,58,237,.1);color:#a78bfa"><i class="fas fa-microchip"></i></div>
        <div class="value">{{ number_format($stats['total_products']) }}</div>
        <div class="label">Products</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(245,158,11,.1);color:var(--warning)"><i class="fas fa-users"></i></div>
        <div class="value">{{ number_format($stats['total_customers']) }}</div>
        <div class="label">Customers</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(245,158,11,.1);color:var(--warning)"><i class="fas fa-clock"></i></div>
        <div class="value" style="color:var(--warning)">{{ $stats['pending_orders'] }}</div>
        <div class="label">Pending Orders</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(239,68,68,.1);color:var(--danger)"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="value" style="color:var(--danger)">{{ $stats['out_of_stock'] }}</div>
        <div class="label">Out of Stock</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h3>Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <table class="table">
            <thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" style="color:var(--accent)">{{ $order->order_number }}</a></td>
                    <td style="color:var(--muted)">{{ $order->user->name ?? '—' }}</td>
                    <td style="font-weight:700">${{ number_format($order->total, 2) }}</td>
                    <td><span class="badge badge-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top Products -->
    <div class="card">
        <div class="card-header">
            <h3>Top Selling Products</h3>
        </div>
        <table class="table">
            <thead><tr><th>Product</th><th>Sold</th><th>Revenue</th></tr></thead>
            <tbody>
                @foreach($topProducts as $p)
                <tr>
                    <td style="font-size:.8rem">{{ Str::limit($p->product_name, 30) }}</td>
                    <td>{{ $p->total_sold }}</td>
                    <td style="color:var(--success)">${{ number_format($p->revenue, 2) }}</td>
                </tr>
                @endforeach
                @if($topProducts->isEmpty())
                <tr><td colspan="3" style="text-align:center;color:var(--muted);padding:2rem">No sales yet</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($stats['low_stock'] > 0 || $stats['out_of_stock'] > 0)
<div style="margin-top:1.5rem;background:#2d1b01;border:1px solid var(--warning);border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:.75rem">
    <i class="fas fa-exclamation-triangle" style="color:var(--warning)"></i>
    <span style="font-size:.875rem">
        <strong>Stock Alert:</strong>
        {{ $stats['out_of_stock'] }} product(s) are out of stock and {{ $stats['low_stock'] }} product(s) are running low.
        <a href="{{ route('admin.products.index') }}" style="color:var(--warning);text-decoration:underline;margin-left:.5rem">Review Products</a>
    </span>
</div>
@endif
@endsection
