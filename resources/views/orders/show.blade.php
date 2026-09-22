@extends('layouts.app')
@section('title', 'Order ' . $order->order_number . ' — PCStore')

@section('content')
<div class="container py-5">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem">
        <div>
            <h1 class="section-title">Order <span>{{ $order->order_number }}</span></h1>
            <p style="color:var(--muted);font-size:.9rem;margin-top:.25rem">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <span class="badge badge-{{ $order->status_badge }}" style="font-size:.8rem;padding:.4rem 1rem">{{ ucfirst($order->status) }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start">
        <!-- Items -->
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--border)">
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.1rem">Order Items</h3>
            </div>
            <table class="table">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div>
                                <p style="font-weight:600;font-size:.9rem">{{ $item->product_name }}</p>
                                @if($item->product)
                                    <a href="{{ route('products.show', $item->product) }}" style="font-size:.75rem;color:var(--accent)">View product</a>
                                @endif
                            </div>
                        </td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="font-weight:700">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:1.25rem 1.5rem;border-top:1px solid var(--border);display:flex;flex-direction:column;align-items:flex-end;gap:.5rem">
                <div style="display:flex;justify-content:space-between;width:200px;font-size:.9rem">
                    <span style="color:var(--muted)">Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;width:200px;font-size:.9rem">
                    <span style="color:var(--muted)">Tax</span><span>${{ number_format($order->tax, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;width:200px;font-size:.9rem">
                    <span style="color:var(--muted)">Shipping</span><span>{{ $order->shipping == 0 ? 'FREE' : '$'.number_format($order->shipping,2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;width:200px;font-weight:700;font-size:1.1rem;padding-top:.5rem;border-top:1px solid var(--border)">
                    <span>Total</span><span style="color:var(--accent)">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Info -->
        <div style="display:flex;flex-direction:column;gap:1rem">
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:1.5rem">
                <h4 style="font-family:'Rajdhani',sans-serif;margin-bottom:1rem;font-size:1rem"><i class="fas fa-truck" style="color:var(--accent)"></i> Shipping Address</h4>
                <address style="font-style:normal;color:var(--muted);font-size:.9rem;line-height:1.8">
                    <strong style="color:var(--text)">{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                    {{ $order->shipping_country }}<br>
                    <br>
                    <i class="fas fa-envelope"></i> {{ $order->shipping_email }}<br>
                    <i class="fas fa-phone"></i> {{ $order->shipping_phone }}
                </address>
            </div>

            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:1.5rem">
                <h4 style="font-family:'Rajdhani',sans-serif;margin-bottom:.75rem;font-size:1rem"><i class="fas fa-info-circle" style="color:var(--accent)"></i> Order Status</h4>
                <div style="display:flex;flex-direction:column;gap:.5rem">
                    @foreach(['pending','processing','shipped','delivered'] as $step)
                    @php $done = in_array($step, ['pending','processing','shipped','delivered']) && array_search($step, ['pending','processing','shipped','delivered']) <= array_search($order->status, ['pending','processing','shipped','delivered','cancelled']); @endphp
                    <div style="display:flex;align-items:center;gap:.75rem;font-size:.875rem">
                        <div style="width:20px;height:20px;border-radius:50%;background:{{ $order->status !== 'cancelled' && $done ? 'var(--accent)' : 'var(--surface2)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            @if($order->status !== 'cancelled' && $done)<i class="fas fa-check" style="font-size:.6rem;color:#000"></i>@endif
                        </div>
                        <span style="color:{{ $order->status !== 'cancelled' && $done ? 'var(--text)' : 'var(--muted)' }}">{{ ucfirst($step) }}</span>
                    </div>
                    @endforeach
                    @if($order->status === 'cancelled')
                    <div style="display:flex;align-items:center;gap:.75rem;font-size:.875rem">
                        <div style="width:20px;height:20px;border-radius:50%;background:var(--danger);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fas fa-times" style="font-size:.6rem;color:#fff"></i>
                        </div>
                        <span style="color:var(--danger)">Cancelled</span>
                    </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection
