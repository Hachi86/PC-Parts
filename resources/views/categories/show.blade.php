@extends('layouts.app')
@section('title', $category->name . ' — PCStore')

@section('content')
<div style="background:var(--surface);border-bottom:1px solid var(--border);padding:2rem 0">
    <div class="container">
        <nav style="font-size:.85rem;color:var(--muted);margin-bottom:.75rem">
            <a href="{{ route('home') }}" style="color:var(--muted)">Home</a> /
            <a href="{{ route('categories.index') }}" style="color:var(--muted)">Categories</a> /
            <span style="color:var(--text)">{{ $category->name }}</span>
        </nav>
        <h1 class="section-title">{{ $category->name }}</h1>
        @if($category->description)
            <p style="color:var(--muted);margin-top:.5rem">{{ $category->description }}</p>
        @endif
        <p style="color:var(--muted);font-size:.85rem;margin-top:.35rem">{{ $products->total() }} products</p>
    </div>
</div>

<div class="container py-4">
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
        <div style="text-align:center;padding:5rem;color:var(--muted)">
            <i class="fas fa-box-open" style="font-size:3rem;margin-bottom:1rem;display:block"></i>
            <p>No products available in this category yet.</p>
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">Browse All Products</a>
        </div>
    @endif
</div>
@endsection
