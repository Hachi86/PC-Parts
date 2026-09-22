@extends('layouts.app')
@section('title', 'Shopping Cart — PCStore')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-3">Shopping <span>Cart</span></h1>

    @if($items->isEmpty())
        <div style="text-align:center;padding:5rem;background:var(--surface);border:1px solid var(--border);border-radius:16px">
            <i class="fas fa-shopping-cart" style="font-size:4rem;color:var(--muted);margin-bottom:1.5rem;display:block"></i>
            <h3 style="margin-bottom:.75rem;color:var(--muted)">Your cart is empty</h3>
            <p style="color:var(--muted);margin-bottom:1.5rem">Browse our products and add something awesome!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-th-large"></i> Browse Products
            </a>
        </div>
    @else
        <div style="display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start">
            <!-- Cart Items -->
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:1rem">
                                    <div style="width:56px;height:56px;background:var(--surface2);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;overflow:hidden">
                                        @if($item['product']->image)
                                            <img src="{{ $item['product']->image_url }}" alt="" style="width:100%;height:100%;object-fit:cover">
                                        @else
                                            <i class="fas fa-microchip" style="color:var(--muted)"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('products.show', $item['product']) }}" style="font-weight:600;font-size:.9rem">{{ $item['product']->name }}</a>
                                        <p style="font-size:.75rem;color:var(--muted)">{{ $item['product']->brand }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--accent);font-weight:600">${{ number_format($item['product']->current_price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item['product']) }}" method="POST" style="display:flex;gap:.4rem;align-items:center">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}"
                                        style="width:60px;background:var(--surface2);border:1px solid var(--border);border-radius:6px;color:var(--text);padding:.35rem .5rem;font-size:.85rem;text-align:center;">
                                    <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                                </form>
                            </td>
                            <td style="font-weight:700">${{ number_format($item['subtotal'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding:1rem;display:flex;justify-content:flex-end">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Clear cart?')">
                            <i class="fas fa-trash-alt"></i> Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary -->
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:1.5rem;position:sticky;top:80px">
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.25rem;margin-bottom:1.25rem">Order Summary</h3>

                <div style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1.25rem">
                    <div style="display:flex;justify-content:space-between;font-size:.9rem">
                        <span style="color:var(--muted)">Subtotal</span>
                        <span>${{ number_format($total['subtotal'], 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.9rem">
                        <span style="color:var(--muted)">Tax (20%)</span>
                        <span>${{ number_format($total['tax'], 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.9rem">
                        <span style="color:var(--muted)">Shipping</span>
                        <span>{{ $total['shipping'] == 0 ? '<span style="color:var(--success)">FREE</span>' : '$'.number_format($total['shipping'],2) }}</span>
                    </div>
                    @if($total['shipping'] == 0)
                        <p style="font-size:.75rem;color:var(--success);text-align:right"><i class="fas fa-check"></i> Free shipping applied!</p>
                    @else
                        <p style="font-size:.75rem;color:var(--muted)">${{ number_format(100 - $total['subtotal'], 2) }} more for free shipping</p>
                    @endif
                    <div style="border-top:1px solid var(--border);padding-top:.75rem;display:flex;justify-content:space-between;font-weight:700;font-size:1.1rem">
                        <span>Total</span>
                        <span style="color:var(--accent)">${{ number_format($total['total'], 2) }}</span>
                    </div>
                </div>

                @auth
                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg w-full">
                        <i class="fas fa-lock"></i> Proceed to Checkout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-full">
                        <i class="fas fa-sign-in-alt"></i> Login to Checkout
                    </a>
                    <p style="text-align:center;font-size:.8rem;color:var(--muted);margin-top:.75rem">
                        New customer? <a href="{{ route('register') }}" style="color:var(--accent)">Create account</a>
                    </p>
                @endauth

                <a href="{{ route('products.index') }}" class="btn btn-secondary w-full mt-2">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
