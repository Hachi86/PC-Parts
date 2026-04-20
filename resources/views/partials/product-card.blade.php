<div class="product-card">
    <a href="{{ route('products.show', $product) }}">
        <div class="product-thumb">
            @if($product->image)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            @else
                <i class="fas fa-microchip"></i>
            @endif
            @if($product->is_on_sale)
                <span class="product-badge">-{{ $product->discount_percent }}%</span>
            @elseif($product->is_featured)
                <span class="product-badge featured">Featured</span>
            @endif
        </div>
    </a>
    <div class="product-info">
        <div class="product-brand">{{ $product->brand }}</div>
        <a href="{{ route('products.show', $product) }}">
            <div class="product-name">{{ $product->name }}</div>
        </a>
        <div class="product-price">
            <span class="price-current">${{ number_format($product->current_price, 2) }}</span>
            @if($product->is_on_sale)
                <span class="price-original">${{ number_format($product->price, 2) }}</span>
            @endif
        </div>
    </div>
    <div class="product-footer">
        @if($product->stock > 5)
            <span class="stock-ok"><i class="fas fa-check-circle"></i> In Stock</span>
        @elseif($product->stock > 0)
            <span class="stock-low"><i class="fas fa-exclamation-circle"></i> Only {{ $product->stock }} left</span>
        @else
            <span class="text-danger" style="font-size:.75rem"><i class="fas fa-times-circle"></i> Out of Stock</span>
        @endif

        <form action="{{ route('cart.add', $product) }}" method="POST">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary btn-sm" @if(!$product->isInStock()) disabled @endif>
                <i class="fas fa-cart-plus"></i>
            </button>
        </form>
    </div>
</div>
