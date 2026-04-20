@extends('layouts.app')
@section('title', 'Search: ' . $q . ' — PCStore')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-1">
        Search results for <span>"{{ $q }}"</span>
    </h1>
    <p style="color:var(--muted);margin-bottom:2rem">{{ $products->total() }} result(s) found</p>

    @if($products->count())
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:1.25rem">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div style="margin-top:2rem;display:flex;justify-content:center">
            {{ $products->links() }}
        </div>
    @else
        <div style="text-align:center;padding:5rem;background:var(--surface);border:1px solid var(--border);border-radius:16px">
            <i class="fas fa-search" style="font-size:3.5rem;color:var(--muted);margin-bottom:1.25rem;display:block"></i>
            <h3 style="color:var(--muted);margin-bottom:.75rem">No results for "{{ $q }}"</h3>
            <p style="color:var(--muted);font-size:.9rem;margin-bottom:1.5rem">Try different keywords or browse our categories.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse All Products</a>
        </div>
    @endif
</div>
@endsection
