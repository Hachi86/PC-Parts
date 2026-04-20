@extends('layouts.app')
@section('title', 'PCStore — Premium Computer Parts')

@push('styles')
<style>
.hero {
    background: linear-gradient(135deg, #0d0f14 0%, #161921 50%, #0d1a2e 100%);
    border-bottom: 1px solid var(--border);
    padding: 5rem 0 4rem;
    position: relative; overflow: hidden;
}
.hero::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 70% 50%, rgba(0,212,255,.07), transparent);
    pointer-events: none;
}
.hero-inner {
    max-width: 1400px; margin: auto; padding: 0 1.5rem;
    display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;
}
.hero-tag {
    display: inline-block; background: rgba(0,212,255,.1); border: 1px solid rgba(0,212,255,.3);
    color: var(--accent); font-size: .75rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; padding: .3rem .75rem; border-radius: 999px; margin-bottom: 1.25rem;
}
.hero h1 {
    font-family: 'Rajdhani', sans-serif; font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700; line-height: 1.1; margin-bottom: 1.25rem;
}
.hero h1 .accent { color: var(--accent); }
.hero p { color: var(--muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem; }
.hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; }
.hero-stats { display: flex; gap: 2rem; margin-top: 2.5rem; }
.hero-stat span { display: block; font-family: 'Rajdhani', sans-serif; font-size: 1.75rem; font-weight: 700; color: var(--accent); }
.hero-stat small { font-size: .8rem; color: var(--muted); }
.hero-image { position: relative; }
.hero-glow {
    position: absolute; inset: -30px;
    background: radial-gradient(ellipse, rgba(0,212,255,.15), transparent 70%);
    pointer-events: none;
}
.hero-image img { position: relative; z-index: 1; border-radius: 16px; border: 1px solid var(--border); }

.products-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.25rem;
}
.product-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; transition: border-color .2s, transform .2s; }
.product-card:hover { border-color: var(--accent); transform: translateY(-3px); }
.product-thumb {
    aspect-ratio: 1; background: var(--surface2); display: flex; align-items: center; justify-content: center;
    font-size: 3rem; color: var(--muted); position: relative; overflow: hidden;
}
.product-thumb img { width: 100%; height: 100%; object-fit: cover; }
.product-badge {
    position: absolute; top: .75rem; left: .75rem;
    background: var(--danger); color: #fff; font-size: .7rem; font-weight: 700;
    padding: .15rem .5rem; border-radius: 4px;
}
.product-badge.featured { background: var(--accent2); }
.product-info { padding: 1rem; }
.product-brand { font-size: .7rem; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); margin-bottom: .25rem; }
.product-name { font-weight: 600; font-size: .9rem; line-height: 1.4; margin-bottom: .5rem; color: var(--text); }
.product-price { display: flex; align-items: center; gap: .6rem; }
.price-current { font-family: 'Rajdhani', sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--accent); }
.price-original { font-size: .8rem; color: var(--muted); text-decoration: line-through; }
.product-footer { padding: .75rem 1rem; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
.stock-ok  { font-size: .75rem; color: var(--success); }
.stock-low { font-size: .75rem; color: var(--warning); }

.cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
.cat-card {
    background: var(--surface); border: 1px solid var(--border); border-radius: 12px;
    padding: 1.5rem 1rem; text-align: center; transition: all .2s;
}
.cat-card:hover { border-color: var(--accent); background: var(--surface2); }
.cat-icon { font-size: 2rem; margin-bottom: .75rem; color: var(--accent); }
.cat-name { font-weight: 600; font-size: .9rem; }
.cat-count { font-size: .75rem; color: var(--muted); margin-top: .2rem; }

.section { padding: 3.5rem 0; }
.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="hero">
    <div class="hero-inner">
        <div>
            <div class="hero-tag"><i class="fas fa-bolt"></i> &nbsp;New Arrivals 2024</div>
            <h1>Build Your <span class="accent">Dream PC</span><br>With the Best Parts</h1>
            <p>Shop premium CPUs, GPUs, motherboards, RAM, and more. Everything you need to build a powerhouse — in one place.</p>
            <div class="hero-actions">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg"><i class="fas fa-th-large"></i> Shop All Parts</a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-lg">Browse Categories</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat"><span>500+</span><small>Products</small></div>
                <div class="hero-stat"><span>50+</span><small>Brands</small></div>
                <div class="hero-stat"><span>24h</span><small>Shipping</small></div>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-glow"></div>
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:2rem;text-align:center;font-size:8rem;">🖥️</div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Shop by <span>Category</span></h2>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="cat-grid">
            @foreach($categories as $cat)
            @php
                $icons = ['cpus-processors'=>'fa-microchip','motherboards'=>'fa-server','memory-ram'=>'fa-memory','storage'=>'fa-hdd','graphics-cards'=>'fa-tv','power-supplies'=>'fa-bolt','pc-cases'=>'fa-desktop','cooling'=>'fa-snowflake'];
                $icon = $icons[$cat->slug] ?? 'fa-puzzle-piece';
            @endphp
            <a href="{{ route('categories.show', $cat) }}" class="cat-card">
                <div class="cat-icon"><i class="fas {{ $icon }}"></i></div>
                <div class="cat-name">{{ $cat->name }}</div>
                <div class="cat-count">{{ $cat->products_count }} products</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count())
<section class="section" style="background:var(--surface);border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><span>Featured</span> Products</h2>
            <a href="{{ route('products.index', ['featured'=>1]) }}" class="btn btn-secondary btn-sm">See All</a>
        </div>
        <div class="products-grid">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Sale Products -->
@if($saleProducts->count())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">🔥 <span>Hot Deals</span></h2>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">All Deals</a>
        </div>
        <div class="products-grid">
            @foreach($saleProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Products -->
<section class="section" style="background:var(--surface);border-top:1px solid var(--border)">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Latest <span>Arrivals</span></h2>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="products-grid">
            @foreach($latestProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- Banner -->
<section style="padding:3rem 0;">
    <div class="container">
        <div style="background:linear-gradient(135deg,var(--surface2),#0d1a2e);border:1px solid var(--border);border-radius:16px;padding:3rem;text-align:center;position:relative;overflow:hidden;">
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 50% 0%,rgba(0,212,255,.1),transparent 60%);pointer-events:none;"></div>
            <h2 class="section-title" style="font-size:2rem;margin-bottom:.75rem">Free Shipping on Orders <span>Over $100</span></h2>
            <p style="color:var(--muted);margin-bottom:1.5rem">Fast delivery. No minimum on select items. 30-day returns.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </div>
</section>
@endsection
