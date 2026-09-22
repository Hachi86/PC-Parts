@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <div>
        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.5rem">{{ $order->order_number }}</h2>
        <p style="font-size:.85rem;color:var(--muted)">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">
    <div style="display:flex;flex-direction:column;gap:1.25rem">
        <!-- Items -->
        <div class="card">
            <div class="card-header"><h3>Order Items</h3></div>
            <table class="table">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="font-size:.875rem">{{ $item->product_name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="font-weight:700">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--border);display:flex;flex-direction:column;align-items:flex-end;gap:.4rem">
                <div style="display:flex;justify-content:space-between;width:180px;font-size:.875rem"><span style="color:var(--muted)">Subtotal</span><span>${{ number_format($order->subtotal,2) }}</span></div>
                <div style="display:flex;justify-content:space-between;width:180px;font-size:.875rem"><span style="color:var(--muted)">Tax</span><span>${{ number_format($order->tax,2) }}</span></div>
                <div style="display:flex;justify-content:space-between;width:180px;font-size:.875rem"><span style="color:var(--muted)">Shipping</span><span>{{ $order->shipping==0 ? 'FREE' : '$'.number_format($order->shipping,2) }}</span></div>
                <div style="display:flex;justify-content:space-between;width:180px;font-weight:700;font-size:1rem;padding-top:.4rem;border-top:1px solid var(--border)"><span>Total</span><span style="color:var(--accent)">${{ number_format($order->total,2) }}</span></div>
            </div>
        </div>

        <!-- Shipping -->
        <div class="card">
            <div class="card-header"><h3>Shipping Address</h3></div>
            <div class="card-body">
                <address style="font-style:normal;color:var(--muted);font-size:.875rem;line-height:2">
                    <strong style="color:var(--text)">{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                    {{ $order->shipping_country }}<br>
                    <i class="fas fa-envelope"></i> {{ $order->shipping_email }} &nbsp;
                    <i class="fas fa-phone"></i> {{ $order->shipping_phone }}
                </address>
                @if($order->notes)
                    <p style="margin-top:.75rem;font-size:.875rem"><strong>Notes:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Update -->
    <div style="display:flex;flex-direction:column;gap:1.25rem">
        <div class="card">
            <div class="card-header"><h3>Update Status</h3></div>
            <div class="card-body">
                <p style="font-size:.85rem;color:var(--muted);margin-bottom:.75rem">
                    Current: <span class="badge badge-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                </p>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="form-label">New Status</label>
                        <select name="status" class="form-control">
                            @foreach(\App\Models\Order::statuses() as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full"><i class="fas fa-save"></i> Update Status</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3>Customer</h3></div>
            <div class="card-body" style="font-size:.875rem;color:var(--muted);line-height:2">
                <strong style="color:var(--text)">{{ $order->user->name ?? '—' }}</strong><br>
                {{ $order->user->email ?? '—' }}<br>
                Member since: {{ $order->user?->created_at->format('M Y') ?? '—' }}
            </div>
        </div>
    </div>
</div>
@endsection
