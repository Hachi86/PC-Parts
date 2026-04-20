@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.5rem">All Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
</div>

<!-- Filters -->
<div class="card mb-2" style="margin-bottom:1.25rem">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap">
            <div style="flex:1;min-width:180px">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name or SKU..." value="{{ request('search') }}">
            </div>
            <div style="min-width:160px">
                <label class="form-label">Category</label>
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:120px">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="active"   {{ request('status')==='active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr><th>Product</th><th>SKU</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:.75rem">
                        <div style="width:40px;height:40px;background:var(--surface2);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" style="width:100%;height:100%;object-fit:cover" alt="">
                            @else
                                <i class="fas fa-microchip" style="color:var(--muted);font-size:.8rem"></i>
                            @endif
                        </div>
                        <div>
                            <p style="font-weight:600;font-size:.875rem">{{ Str::limit($product->name, 40) }}</p>
                            <p style="font-size:.75rem;color:var(--muted)">{{ $product->brand }}</p>
                        </div>
                    </div>
                </td>
                <td style="color:var(--muted);font-size:.8rem">{{ $product->sku }}</td>
                <td style="font-size:.8rem">{{ $product->category->name }}</td>
                <td>
                    <span style="color:var(--accent);font-weight:700">${{ number_format($product->current_price, 2) }}</span>
                    @if($product->is_on_sale)<br><small style="color:var(--muted);text-decoration:line-through">${{ number_format($product->price, 2) }}</small>@endif
                </td>
                <td>
                    @if($product->stock == 0)
                        <span style="color:var(--danger);font-weight:600">0</span>
                    @elseif($product->stock <= 5)
                        <span style="color:var(--warning);font-weight:600">{{ $product->stock }}</span>
                    @else
                        {{ $product->stock }}
                    @endif
                </td>
                <td>
                    @if($product->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                    @if($product->is_featured)
                        <span class="badge badge-info">Featured</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:.35rem">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:3rem">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:1rem;display:flex;justify-content:center">
        {{ $products->links() }}
    </div>
</div>
@endsection
