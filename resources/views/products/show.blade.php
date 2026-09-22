@extends('layouts.app')
@section('title', $product->name . ' — PCStore')

@push('styles')
<style>
.product-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; padding: 2.5rem 0; }
.product-image-box {
    background: var(--surface); border: 1px solid var(--border); border-radius: 16px;
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    font-size: 10rem; color: var(--muted); overflow: hidden;
}
.product-image-box img { width: 100%; height: 100%; object-fit: cover; }
.product-detail-brand { color: var(--muted); font-size: .8rem; text-transform: uppercase; letter-spacing: .1em; margin-bottom: .5rem; }
.product-detail-name { font-family: 'Rajdhani', sans-serif; font-size: 2rem; font-weight: 700; line-height: 1.2; margin-bottom: 1rem; }
.product-detail-price { display: flex; align-items: baseline; gap: 1rem; margin-bottom: 1.5rem; }
.price-big { font-family: 'Rajdhani', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--accent); }
.price-old { font-size: 1.2rem; color: var(--muted); text-decoration: line-through; }
.discount-pill { background: var(--danger); color: #fff; font-size: .75rem; font-weight: 700; padding: .2rem .6rem; border-radius: 999px; }
.specs-table { width: 100%; border-collapse: collapse; margin-top: .75rem; }
.specs-table tr td { padding: .5rem .75rem; border-bottom: 1px solid var(--border); font-size: .875rem; }
.specs-table tr td:first-child { color: var(--muted); width: 40%; }
.qty-input { display: flex; align-items: center; gap: .5rem; }
.qty-btn {
    width: 34px; height: 34px; background: var(--surface2); border: 1px solid var(--border);
    border-radius: var(--radius); color: var(--text); font-size: 1rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: border-color .2s;
}
.qty-btn:hover { border-color: var(--accent); color: var(--accent); }
.qty-field {
    width: 60px; text-align: center; background: var(--surface2); border: 1px solid var(--border);
    border-radius: var(--radius); color: var(--text); padding: .4rem; font-size: .9rem;
}
@media(max-width:768px){ .product-layout{ grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div class="container" style="padding-top:1rem">
    <!-- Breadcrumb -->
    <nav style="font-size:.85rem;color:var(--muted);margin-bottom:1rem">
        <a href="{{ route('home') }}" style="color:var(--muted)">Home</a> /
        <a href="{{ route('products.index') }}" style="color:var(--muted)">Products</a> /
        <a href="{{ route('categories.show', $product->category) }}" style="color:var(--muted)">{{ $product->category->name }}</a> /
        <span style="color:var(--text)">{{ $product->name }}</span>
    </nav>

    <div class="product-layout">
        <!-- Image -->
        <div>
            <div class="product-image-box">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-microchip"></i>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div>
            <div class="product-detail-brand">{{ $product->brand }}</div>
            <h1 class="product-detail-name">{{ $product->name }}</h1>

            <div class="product-detail-price">
                <span class="price-big">${{ number_format($product->current_price, 2) }}</span>
                @if($product->is_on_sale)
                    <span class="price-old">${{ number_format($product->price, 2) }}</span>
                    <span class="discount-pill">Save {{ $product->discount_percent }}%</span>
                @endif
            </div>

            <!-- Stock -->
            @if($product->stock > 5)
                <p class="text-success mb-2"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} available)</p>
            @elseif($product->stock > 0)
                <p style="color:var(--warning)" class="mb-2"><i class="fas fa-exclamation-circle"></i> Only {{ $product->stock }} left in stock</p>
            @else
                <p class="text-danger mb-2"><i class="fas fa-times-circle"></i> Out of Stock</p>
            @endif

            <!-- Category -->
            <p class="text-sm text-muted mb-3">
                Category: <a href="{{ route('categories.show', $product->category) }}" style="color:var(--accent)">{{ $product->category->name }}</a> &nbsp;·&nbsp; SKU: {{ $product->sku }}
            </p>

            <!-- Short description -->
            @if($product->short_description)
                <p style="color:var(--muted);line-height:1.7;margin-bottom:1.5rem">{{ $product->short_description }}</p>
            @endif

            <!-- Add to Cart -->
            @if($product->isInStock())
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <div class="qty-input mb-2">
                    <button type="button" class="qty-btn" onclick="let v=+document.getElementById('qty').value;if(v>1)document.getElementById('qty').value=v-1">-</button>
                    <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-field">
                    <button type="button" class="qty-btn" onclick="let v=+document.getElementById('qty').value;if(v<{{ $product->stock }})document.getElementById('qty').value=v+1">+</button>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-full">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </form>
            @else
                <button class="btn btn-secondary btn-lg w-full" disabled>Out of Stock</button>
            @endif
        </div>
    </div>

    <!-- Tabs: Description & Specs -->
    <div style="margin-top:3rem">
        <div style="display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:2rem">
            <button id="tab-desc" onclick="showTab('desc')" style="padding:.75rem 1.5rem;background:none;border:none;border-bottom:2px solid var(--accent);color:var(--text);cursor:pointer;font-weight:600">Description</button>
            @if($product->specs)
            <button id="tab-specs" onclick="showTab('specs')" style="padding:.75rem 1.5rem;background:none;border:none;border-bottom:2px solid transparent;color:var(--muted);cursor:pointer;font-weight:600">Specifications</button>
            @endif
        </div>

        <div id="panel-desc">
            <p style="color:var(--muted);line-height:1.8">{{ $product->description }}</p>
        </div>

        @if($product->specs)
        <div id="panel-specs" style="display:none">
            <table class="specs-table">
                @foreach($product->specs as $key => $val)
                <tr><td>{{ $key }}</td><td>{{ $val }}</td></tr>
                @endforeach
            </table>
        </div>
        @endif
    </div>

    <!-- Related Products -->
    @if($related->count())
    <div style="margin-top:3.5rem">
        <h2 class="section-title mb-3">Related <span>Products</span></h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem">
            @foreach($related as $p)
                @include('partials.product-card', ['product' => $p])
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function showTab(name) {
    ['desc','specs'].forEach(t => {
        document.getElementById('panel-'+t)?.style && (document.getElementById('panel-'+t).style.display = t===name ? 'block':'none');
        if(document.getElementById('tab-'+t)){
            document.getElementById('tab-'+t).style.borderBottomColor = t===name ? 'var(--accent)':'transparent';
            document.getElementById('tab-'+t).style.color = t===name ? 'var(--text)':'var(--muted)';
        }
    });
}
</script>
@endpush
