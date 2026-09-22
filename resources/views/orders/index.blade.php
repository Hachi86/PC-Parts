@extends('layouts.app')
@section('title', 'My Orders — PCStore')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-3">My <span>Orders</span></h1>

    @if($orders->isEmpty())
        <div style="text-align:center;padding:4rem;background:var(--surface);border:1px solid var(--border);border-radius:16px">
            <i class="fas fa-box-open" style="font-size:3.5rem;color:var(--muted);margin-bottom:1.25rem;display:block"></i>
            <h3 style="margin-bottom:.75rem;color:var(--muted)">No orders yet</h3>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">Start Shopping</a>
        </div>
    @else
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th><th>Date</th><th>Items</th><th>Total</th><th>Status</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td style="font-weight:600;color:var(--accent)">{{ $order->order_number }}</td>
                        <td style="color:var(--muted);font-size:.875rem">{{ $order->created_at->format('M d, Y') }}</td>
                        <td style="font-size:.875rem">{{ $order->items->count() }} item(s)</td>
                        <td style="font-weight:700">${{ number_format($order->total, 2) }}</td>
                        <td><span class="badge badge-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        <td><a href="{{ route('orders.show', $order) }}" class="btn btn-secondary btn-sm">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1.5rem;display:flex;justify-content:center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
