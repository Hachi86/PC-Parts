@extends('layouts.app')
@section('title', 'Categories — PCStore')

@push('styles')
<style>
.cat-hero { background: var(--surface); border-bottom: 1px solid var(--border); padding: 2.5rem 0; }
.cat-big-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.25rem; padding: 3rem 0; }
.cat-big-card {
    background: var(--surface); border: 1px solid var(--border); border-radius: 16px;
    padding: 2rem 1.5rem; text-align: center; transition: all .25s; position: relative; overflow: hidden;
}
.cat-big-card::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse at 50% 0%, rgba(0,212,255,.06), transparent 70%);
    opacity: 0; transition: opacity .25s;
}
.cat-big-card:hover { border-color: var(--accent); transform: translateY(-4px); }
.cat-big-card:hover::before { opacity: 1; }
.cat-big-icon { font-size: 2.75rem; color: var(--accent); margin-bottom: 1rem; position: relative; }
.cat-big-name { font-family: 'Rajdhani', sans-serif; font-size: 1.2rem; font-weight: 700; margin-bottom: .4rem; }
.cat-big-desc { font-size: .8rem; color: var(--muted); line-height: 1.6; margin-bottom: 1rem; }
.cat-big-count { display: inline-block; background: rgba(0,212,255,.1); color: var(--accent); font-size: .75rem; font-weight: 700; padding: .2rem .7rem; border-radius: 999px; }
</style>
@endpush

@section('content')
<div class="cat-hero">
    <div class="container">
        <h1 class="section-title">All <span>Categories</span></h1>
        <p style="color:var(--muted);margin-top:.5rem">Browse our full range of PC components by category</p>
    </div>
</div>

<div class="container">
    <div class="cat-big-grid">
        @php
            $icons = ['cpus-processors'=>'fa-microchip','motherboards'=>'fa-server','memory-ram'=>'fa-memory','storage'=>'fa-hdd','graphics-cards'=>'fa-tv','power-supplies'=>'fa-bolt','pc-cases'=>'fa-desktop','cooling'=>'fa-snowflake'];
        @endphp
        @foreach($categories as $cat)
        <a href="{{ route('categories.show', $cat) }}" class="cat-big-card">
            <div class="cat-big-icon">
                <i class="fas {{ $icons[$cat->slug] ?? 'fa-puzzle-piece' }}"></i>
            </div>
            <div class="cat-big-name">{{ $cat->name }}</div>
            @if($cat->description)
                <div class="cat-big-desc">{{ $cat->description }}</div>
            @endif
            <span class="cat-big-count">{{ $cat->products_count }} products</span>
        </a>
        @endforeach
    </div>
</div>
@endsection
