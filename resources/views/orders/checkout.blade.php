@extends('layouts.app')
@section('title', 'Checkout — PCStore')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-3">Checkout</h1>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start">
        <!-- Shipping Form -->
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:2rem;margin-bottom:1.5rem">
                <h3 style="font-family:'Rajdhani',sans-serif;margin-bottom:1.5rem;font-size:1.2rem">
                    <i class="fas fa-truck" style="color:var(--accent);margin-right:.5rem"></i> Shipping Information
                </h3>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                            value="{{ old('shipping_name', $user->name) }}" required>
                        @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="shipping_email" class="form-control @error('shipping_email') is-invalid @enderror"
                            value="{{ old('shipping_email', $user->email) }}" required>
                        @error('shipping_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                            value="{{ old('shipping_phone', $user->phone) }}" required>
                        @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Street Address *</label>
                        <input type="text" name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                            value="{{ old('shipping_address', $user->address) }}" required>
                        @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">City *</label>
                        <input type="text" name="shipping_city" class="form-control @error('shipping_city') is-invalid @enderror"
                            value="{{ old('shipping_city', $user->city) }}" required>
                        @error('shipping_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">State/Province *</label>
                        <input type="text" name="shipping_state" class="form-control @error('shipping_state') is-invalid @enderror"
                            value="{{ old('shipping_state', $user->state) }}" required>
                        @error('shipping_state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">ZIP / Postal Code *</label>
                        <input type="text" name="shipping_zip" class="form-control @error('shipping_zip') is-invalid @enderror"
                            value="{{ old('shipping_zip', $user->zip) }}" required>
                        @error('shipping_zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Country *</label>
                        <input type="text" name="shipping_country" class="form-control @error('shipping_country') is-invalid @enderror"
                            value="{{ old('shipping_country', $user->country ?? 'US') }}" required>
                        @error('shipping_country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Order Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Special instructions...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:2rem">
                <h3 style="font-family:'Rajdhani',sans-serif;margin-bottom:1.5rem;font-size:1.2rem">
                    <i class="fas fa-credit-card" style="color:var(--accent);margin-right:.5rem"></i> Payment
                </h3>
                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:1.25rem;text-align:center;color:var(--muted)">
                    <i class="fas fa-shield-alt" style="font-size:2rem;margin-bottom:.75rem;display:block;color:var(--success)"></i>
                    <p style="font-size:.9rem">Demo mode — No real payment required.<br>Order will be placed immediately.</p>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-full mt-3">
                    <i class="fas fa-lock"></i> Place Order — ${{ number_format($total['total'], 2) }}
                </button>
            </div>
        </form>

        <!-- Order Summary -->
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:1.5rem;position:sticky;top:80px">
            <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;margin-bottom:1.25rem">Order Summary</h3>

            <div style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1.25rem">
                @foreach($items as $item)
                <div style="display:flex;align-items:center;gap:.75rem;padding-bottom:.75rem;border-bottom:1px solid var(--border)">
                    <div style="width:44px;height:44px;background:var(--surface2);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="fas fa-microchip" style="color:var(--muted)"></i>
                    </div>
                    <div style="flex:1;min-width:0">
                        <p style="font-size:.8rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item['product']->name }}</p>
                        <p style="font-size:.75rem;color:var(--muted)">× {{ $item['quantity'] }}</p>
                    </div>
                    <span style="font-size:.9rem;font-weight:700">${{ number_format($item['subtotal'], 2) }}</span>
                </div>
                @endforeach
            </div>

            <div style="display:flex;flex-direction:column;gap:.6rem">
                <div style="display:flex;justify-content:space-between;font-size:.9rem">
                    <span style="color:var(--muted)">Subtotal</span><span>${{ number_format($total['subtotal'], 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:.9rem">
                    <span style="color:var(--muted)">Tax</span><span>${{ number_format($total['tax'], 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:.9rem">
                    <span style="color:var(--muted)">Shipping</span>
                    <span>{{ $total['shipping'] == 0 ? '<span style="color:var(--success)">FREE</span>' : '$'.number_format($total['shipping'],2) }}</span>
                </div>
                <div style="border-top:1px solid var(--border);padding-top:.75rem;display:flex;justify-content:space-between;font-weight:700;font-size:1.1rem">
                    <span>Total</span><span style="color:var(--accent)">${{ number_format($total['total'], 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
