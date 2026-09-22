@extends('layouts.app')
@section('title', 'All Products — PCStore')

@push('styles')
<style>
.page-layout { display: grid; grid-template-columns: 260px 1fr; gap: 2rem; padding: 2rem 0; }
.sidebar { position: sticky; top: 80px; height: fit-content; }
.filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem; margin-bottom: 1rem; }
.filter-card h4 { font-family: 'Rajdhani', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; }
.filter-item { display: flex; align-items: center; gap: .5rem; margin-bottom: .5rem; }
.filter-item label { font-size: .875rem; color: var(--muted); cursor: pointer; transition: color .15s; }
.filter-item label:hover { color: var(--text); }
.filter-item input[type=checkbox] { accent-color: var(--accent); }
.price-range { display: flex; gap: .5rem; }
.price-input { flex: 1; background: var(--surface2); border: 1px solid var(--border); border-radius: 6px; color: var(--text); padding: .4rem .6rem; font-size: .85rem; outline: none; }
.price-input:focus { border-color: var(--accent); }
.sort-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
.sort-select { background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius); color: var(--text); padding: .45rem .8rem; font-size: .875rem; outline: none; cursor: pointer; }
.products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 1.25rem; }
@media(max-width:900px){ .page-layout{ grid-template-columns:1fr; } .sidebar{ position:static; } }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-layout">
        <!-- Sidebar Filters -->
        <aside class="sidebar">
            <form id="filter-form" method="GET" action="{{ route('products.index') }}">
                <input type="hidden" name="sort" value="{{ request('sort','newest') }}">

                <div class="filter-card">
                    <h4>Categories</h4>
                    @foreach($categories as $cat)
                    <div class="filter-item">
                        <input type="radio" name="category" id="cat-{{ $cat->id }}" value="{{ $cat->slug }}"
                            {{ request('category') === $cat->slug ? 'checked' : '' }}
                            onchange="document.getElementById('filter-form').submit()">
                        <label for="cat-{{ $cat->id }}">{{ $cat->name }} <span style="color:var(--muted)">({{ $cat->products_count }})</span></label>
                    </div>
                    @endforeach
                    @if(request('category'))
                        <a href="{{ route('products.index') }}" style="font-size:.8rem;color:var(--accent);margin-top:.5rem;display:block">
                            <i class="fas fa-times"></i> Clear filter
                        </a>
                    @endif
                </div>

                @if($brands->count())
                <div class="filter-card">
                    <h4>Brand</h4>
                    @foreach($brands as $brand)
                    <div class="filter-item">
                        <input type="radio" name="brand" id="brand-{{ Str::slug($brand) }}" value="{{ $brand }}"
                            {{ request('brand') === $brand ? 'checked' : '' }}
                            onchange="document.getElementById('filter-form').submit()">
                        <label for="brand-{{ Str::slug($brand) }}">{{ $brand }}</label>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="filter-card">
                    <h4>Price Range</h4>
                    <div class="price-range">
                        <input type="number" name="min_price" class="price-input" placeholder="Min $" value="{{ request('min_price') }}">
                        <input type="number" name="max_price" class="price-input" placeholder="Max $" value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm w-full mt-2">Apply</button>
                </div>

                @if(request()->hasAny(['category','brand','min_price','max_price']))
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm w-full">
                    <i class="fas fa-undo"></i> Reset Filters
                </a>
                @endif
            </form>
        </aside>

        <!-- Products Area -->
        <div>
            <div class="sort-bar">
                <p class="text-muted text-sm">{{ $products->total() }} products found</p>
                <select class="sort-select" onchange="window.location='{{ route('products.index') }}?'+new URLSearchParams({...Object.fromEntries(new URLSearchParams(location.search)),...{sort:this.value}}).toString()">
                    <option value="newest"     {{ request('sort','newest')==='newest'     ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc"  {{ request('sort')==='price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc"   {{ request('sort')==='name_asc'   ? 'selected' : '' }}>Name A–Z</option>
                </select>
            </div>

            @if($products->count())
                <div class="products-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div style="margin-top:2rem; display:flex; justify-content:center;">
                    {{ $products->links() }}
                </div>
            @else
                <div style="text-align:center;padding:4rem;color:var(--muted);">
                    <i class="fas fa-search" style="font-size:3rem;margin-bottom:1rem;display:block"></i>
                    <p>No products found. Try adjusting your filters.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">Clear Filters</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
