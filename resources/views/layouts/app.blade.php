<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PCStore — Premium Computer Parts')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0d0f14;
            --surface:   #161921;
            --surface2:  #1e2230;
            --border:    #2a2f3f;
            --accent:    #00d4ff;
            --accent2:   #7c3aed;
            --text:      #e2e8f0;
            --muted:     #64748b;
            --success:   #22c55e;
            --danger:    #ef4444;
            --warning:   #f59e0b;
            --radius:    8px;
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }

        /* ── Navbar ── */
        .navbar {
            background: rgba(13, 15, 20, 0.95);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 1000;
            backdrop-filter: blur(12px);
        }
        .nav-inner {
            max-width: 1400px; margin: auto; padding: 0 1.5rem;
            display: flex; align-items: center; gap: 2rem; height: 64px;
        }
        .nav-logo {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.6rem; font-weight: 700; color: var(--accent);
            letter-spacing: 1px; white-space: nowrap;
        }
        .nav-logo span { color: var(--text); }
        .nav-links { display: flex; gap: 0.25rem; flex: 1; }
        .nav-links a {
            padding: 0.4rem 0.9rem; border-radius: var(--radius);
            font-size: 0.9rem; font-weight: 500; color: var(--muted);
            transition: color .2s, background .2s;
        }
        .nav-links a:hover { color: var(--text); background: var(--surface2); }

        .nav-search { flex: 1; max-width: 360px; }
        .nav-search form { display: flex; gap: 0; }
        .nav-search input {
            flex: 1; background: var(--surface2); border: 1px solid var(--border);
            border-right: none; border-radius: var(--radius) 0 0 var(--radius);
            color: var(--text); padding: 0.45rem 0.9rem; font-size: 0.85rem; outline: none;
        }
        .nav-search input:focus { border-color: var(--accent); }
        .nav-search button {
            background: var(--accent); border: none; cursor: pointer; padding: 0 1rem;
            border-radius: 0 var(--radius) var(--radius) 0; color: #000; font-size: 0.85rem;
            transition: opacity .2s;
        }
        .nav-search button:hover { opacity: 0.85; }

        .nav-actions { display: flex; align-items: center; gap: 0.5rem; }
        .nav-icon-btn {
            position: relative; background: var(--surface2); border: 1px solid var(--border);
            border-radius: var(--radius); color: var(--text); padding: 0.45rem 0.75rem;
            cursor: pointer; font-size: 0.9rem; transition: border-color .2s;
            display: flex; align-items: center; gap: 0.4rem;
        }
        .nav-icon-btn:hover { border-color: var(--accent); color: var(--accent); }
        .cart-badge {
            background: var(--accent); color: #000; font-size: 0.65rem; font-weight: 700;
            border-radius: 999px; padding: 1px 6px; min-width: 18px; text-align: center;
        }

        .dropdown { position: relative; }
        .dropdown-menu {
            display: none; position: absolute; right: 0; top: calc(100% + 8px);
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: var(--radius); min-width: 180px; z-index: 999;
            overflow: hidden;
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a, .dropdown-menu button {
            display: block; width: 100%; text-align: left; padding: 0.65rem 1rem;
            font-size: 0.85rem; color: var(--muted); background: none; border: none; cursor: pointer;
            transition: background .15s, color .15s;
        }
        .dropdown-menu a:hover, .dropdown-menu button:hover { background: var(--border); color: var(--text); }

        /* ── Container ── */
        .container { max-width: 1400px; margin: auto; padding: 0 1.5rem; }

        /* ── Flash Messages ── */
        .flash-wrap { position: fixed; top: 76px; right: 1.5rem; z-index: 9999; display: flex; flex-direction: column; gap: .5rem; }
        .flash {
            padding: .75rem 1.25rem; border-radius: var(--radius); font-size: .875rem;
            border-left: 4px solid; animation: slideIn .3s ease; max-width: 360px;
            display: flex; align-items: center; gap: .6rem;
        }
        .flash-success { background: #052e16; border-color: var(--success); color: #4ade80; }
        .flash-error   { background: #2d0e0e; border-color: var(--danger);  color: #f87171; }
        .flash-info    { background: #082f49; border-color: var(--accent);   color: #7dd3fc; }
        @keyframes slideIn { from { transform: translateX(20px); opacity: 0; } to { transform: none; opacity: 1; } }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .6rem 1.25rem; border-radius: var(--radius); font-size: .875rem;
            font-weight: 600; cursor: pointer; border: none; transition: all .2s;
        }
        .btn-primary   { background: var(--accent);  color: #000; }
        .btn-primary:hover { opacity: .85; }
        .btn-secondary { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }
        .btn-secondary:hover { border-color: var(--accent); color: var(--accent); }
        .btn-danger    { background: var(--danger); color: #fff; }
        .btn-danger:hover { opacity: .85; }
        .btn-sm { padding: .35rem .8rem; font-size: .8rem; }
        .btn-lg { padding: .8rem 2rem; font-size: 1rem; }

        /* ── Cards ── */
        .card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: calc(var(--radius) * 1.5); overflow: hidden;
            transition: border-color .2s, transform .2s;
        }
        .card:hover { border-color: var(--accent); transform: translateY(-2px); }

        /* ── Forms ── */
        .form-group { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1.25rem; }
        .form-label { font-size: .85rem; font-weight: 600; color: var(--muted); }
        .form-control {
            background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius);
            color: var(--text); padding: .6rem .9rem; font-size: .9rem; outline: none; width: 100%;
        }
        .form-control:focus { border-color: var(--accent); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: .8rem; }

        /* ── Badges ── */
        .badge {
            display: inline-block; padding: .2rem .6rem; border-radius: 999px;
            font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
        }
        .badge-success { background: #052e16; color: var(--success); }
        .badge-danger  { background: #2d0e0e; color: var(--danger);  }
        .badge-warning { background: #2d1b01; color: var(--warning); }
        .badge-info    { background: #082f49; color: var(--accent);  }
        .badge-primary { background: #2d1b69; color: #c4b5fd; }

        /* ── Tables ── */
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: .75rem 1rem; border-bottom: 1px solid var(--border); text-align: left; }
        .table th { font-size: .75rem; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); background: var(--surface2); }
        .table tr:hover td { background: rgba(255,255,255,.02); }

        /* ── Pagination ── */
        .pagination { display: flex; gap: .35rem; flex-wrap: wrap; }
        .pagination .page-link {
            padding: .45rem .75rem; background: var(--surface2); border: 1px solid var(--border);
            border-radius: var(--radius); font-size: .85rem; color: var(--muted); transition: all .2s;
        }
        .pagination .page-link:hover { border-color: var(--accent); color: var(--accent); }
        .pagination .page-item.active .page-link { background: var(--accent); color: #000; border-color: var(--accent); }
        .pagination .page-item.disabled .page-link { opacity: .4; pointer-events: none; }

        /* ── Section title ── */
        .section-title {
            font-family: 'Rajdhani', sans-serif; font-size: 1.75rem; font-weight: 700;
            color: var(--text); letter-spacing: .5px;
        }
        .section-title span { color: var(--accent); }

        /* ── Footer ── */
        footer {
            margin-top: 5rem; background: var(--surface); border-top: 1px solid var(--border); padding: 3rem 0 1.5rem;
        }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-bottom: 2rem; }
        .footer-col h4 { font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; margin-bottom: .75rem; color: var(--text); }
        .footer-col a { display: block; color: var(--muted); font-size: .875rem; margin-bottom: .4rem; transition: color .2s; }
        .footer-col a:hover { color: var(--accent); }
        .footer-bottom { border-top: 1px solid var(--border); padding-top: 1.25rem; text-align: center; color: var(--muted); font-size: .8rem; }

        /* ── Utility ── */
        .text-accent  { color: var(--accent); }
        .text-muted   { color: var(--muted); }
        .text-success { color: var(--success); }
        .text-danger  { color: var(--danger); }
        .text-warning { color: var(--warning); }
        .mt-1 { margin-top: .5rem; }  .mt-2 { margin-top: 1rem; } .mt-3 { margin-top: 1.5rem; }
        .mb-1 { margin-bottom: .5rem; } .mb-2 { margin-bottom: 1rem; } .mb-3 { margin-bottom: 1.5rem; }
        .py-4 { padding: 2rem 0; } .py-5 { padding: 3rem 0; }
        .flex { display: flex; } .items-center { align-items: center; }
        .justify-between { justify-content: space-between; } .gap-1 { gap: .5rem; } .gap-2 { gap: 1rem; }
        .w-full { width: 100%; } .text-right { text-align: right; } .text-center { text-align: center; }
        .font-bold { font-weight: 700; } .text-sm { font-size: .875rem; } .text-lg { font-size: 1.125rem; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        @media (max-width: 768px) {
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .nav-search { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">PC<span>Store</span></a>

        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('categories.index') }}">Categories</a>
        </div>

        <div class="nav-search">
            <form action="{{ route('products.search') }}" method="GET">
                <input type="text" name="q" placeholder="Search parts, brands..." value="{{ request('q') }}">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="nav-actions">
            <a href="{{ route('cart.index') }}" class="nav-icon-btn">
                <i class="fas fa-shopping-cart"></i>
                @php $cartCount = app(\App\Services\CartService::class)->count(); @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>

            @auth
                <div class="dropdown">
                    <button class="nav-icon-btn">
                        <i class="fas fa-user"></i> {{ Str::words(auth()->user()->name, 1, '') }}
                        <i class="fas fa-chevron-down" style="font-size:.7rem"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile') }}"><i class="fas fa-id-card" style="width:16px"></i> Profile</a>
                        <a href="{{ route('orders.index') }}"><i class="fas fa-box" style="width:16px"></i> My Orders</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt" style="width:16px"></i> Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"><i class="fas fa-sign-out-alt" style="width:16px"></i> Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-icon-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<div class="flash-wrap">
    @if(session('success'))
        <div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="flash flash-info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
    @endif
</div>

@yield('content')

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>PCStore</h4>
                <p style="color:var(--muted);font-size:.85rem;line-height:1.6">Premium computer parts for builders, gamers, and professionals.</p>
            </div>
            <div class="footer-col">
                <h4>Shop</h4>
                <a href="{{ route('products.index') }}">All Products</a>
                <a href="{{ route('categories.index') }}">Categories</a>
                <a href="{{ route('products.index', ['sort' => 'price_asc']) }}">Best Deals</a>
            </div>
            <div class="footer-col">
                <h4>Account</h4>
                @auth
                    <a href="{{ route('profile') }}">My Profile</a>
                    <a href="{{ route('orders.index') }}">My Orders</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
            <div class="footer-col">
                <h4>Info</h4>
                <a href="#">About Us</a>
                <a href="#">Shipping Policy</a>
                <a href="#">Returns</a>
                <a href="#">Contact</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} PCStore. All rights reserved.
        </div>
    </div>
</footer>

<script>
    // Auto-dismiss flash messages
    setTimeout(() => {
        document.querySelectorAll('.flash').forEach(el => {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        });
    }, 4000);
</script>
@stack('scripts')
</body>
</html>
