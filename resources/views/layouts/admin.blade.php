<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — PCStore Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#0d0f14;--surface:#161921;--surface2:#1e2230;--border:#2a2f3f;--accent:#00d4ff;--text:#e2e8f0;--muted:#64748b;--success:#22c55e;--danger:#ef4444;--warning:#f59e0b;--radius:8px}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}
        a{color:inherit;text-decoration:none}

        .sidebar{width:240px;background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto}
        .sidebar-logo{padding:1.5rem;font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;color:var(--accent);border-bottom:1px solid var(--border)}
        .sidebar-logo span{color:var(--text)}
        .sidebar-section{padding:.75rem 1rem .25rem;font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted)}
        .sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.65rem 1rem;margin:.1rem .5rem;border-radius:var(--radius);font-size:.875rem;color:var(--muted);transition:all .15s}
        .sidebar-link:hover,.sidebar-link.active{background:var(--surface2);color:var(--text)}
        .sidebar-link.active{color:var(--accent);border-left:2px solid var(--accent);padding-left:calc(1rem - 2px)}
        .sidebar-link i{width:16px;text-align:center}

        .main{flex:1;display:flex;flex-direction:column;overflow:hidden}
        .topbar{background:var(--surface);border-bottom:1px solid var(--border);padding:0 1.5rem;height:60px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
        .topbar-title{font-family:'Rajdhani',sans-serif;font-size:1.1rem;font-weight:700}
        .topbar-user{display:flex;align-items:center;gap:.75rem;font-size:.875rem;color:var(--muted)}
        .content{flex:1;padding:1.75rem;overflow-y:auto}

        .stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;margin-bottom:2rem}
        .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:1.25rem}
        .stat-card .icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;margin-bottom:.75rem}
        .stat-card .value{font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;line-height:1}
        .stat-card .label{font-size:.8rem;color:var(--muted);margin-top:.25rem}

        .card{background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden}
        .card-header{padding:1rem 1.25rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center}
        .card-header h3{font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700}
        .card-body{padding:1.25rem}

        .table{width:100%;border-collapse:collapse}
        .table th,.table td{padding:.65rem 1rem;border-bottom:1px solid var(--border);text-align:left;font-size:.875rem}
        .table th{font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);background:var(--surface2)}
        .table tr:hover td{background:rgba(255,255,255,.02)}

        .btn{display:inline-flex;align-items:center;gap:.35rem;padding:.5rem 1rem;border-radius:var(--radius);font-size:.8rem;font-weight:600;cursor:pointer;border:none;transition:all .2s}
        .btn-primary{background:var(--accent);color:#000}.btn-primary:hover{opacity:.85}
        .btn-secondary{background:var(--surface2);color:var(--text);border:1px solid var(--border)}.btn-secondary:hover{border-color:var(--accent);color:var(--accent)}
        .btn-danger{background:var(--danger);color:#fff}.btn-danger:hover{opacity:.85}
        .btn-sm{padding:.3rem .65rem;font-size:.75rem}

        .badge{display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.7rem;font-weight:700;text-transform:uppercase}
        .badge-success{background:#052e16;color:var(--success)}.badge-danger{background:#2d0e0e;color:var(--danger)}
        .badge-warning{background:#2d1b01;color:var(--warning)}.badge-info{background:#082f49;color:var(--accent)}.badge-primary{background:#2d1b69;color:#c4b5fd}

        .form-group{display:flex;flex-direction:column;gap:.35rem;margin-bottom:1rem}
        .form-label{font-size:.8rem;font-weight:600;color:var(--muted)}
        .form-control{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);color:var(--text);padding:.55rem .85rem;font-size:.875rem;outline:none;width:100%}
        .form-control:focus{border-color:var(--accent)}
        .is-invalid{border-color:var(--danger)!important}.invalid-feedback{color:var(--danger);font-size:.75rem}

        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
        .grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem}
        .mt-1{margin-top:.5rem}.mt-2{margin-top:1rem}.mt-3{margin-top:1.5rem}
        .mb-2{margin-bottom:1rem}.w-full{width:100%}.text-right{text-align:right}

        .flash-wrap{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem}
        .flash{padding:.7rem 1.1rem;border-radius:var(--radius);font-size:.85rem;border-left:4px solid;animation:slideIn .3s ease;display:flex;align-items:center;gap:.5rem}
        .flash-success{background:#052e16;border-color:var(--success);color:#4ade80}
        .flash-error{background:#2d0e0e;border-color:var(--danger);color:#f87171}
        @keyframes slideIn{from{transform:translateX(20px);opacity:0}to{transform:none;opacity:1}}

        textarea.form-control{resize:vertical;min-height:100px}
        select.form-control{cursor:pointer}
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-logo">PC<span>Store</span> <span style="font-size:.7rem;color:var(--muted);font-family:'Inter'">Admin</span></div>

    <div style="flex:1;padding:.5rem 0">
        <div class="sidebar-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="sidebar-section">Catalog</div>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-microchip"></i> Products
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Categories
        </a>

        <div class="sidebar-section">Sales</div>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders
        </a>

        <div class="sidebar-section">Account</div>
        <a href="{{ route('home') }}" class="sidebar-link"><i class="fas fa-store"></i> View Store</a>
        <form method="POST" action="{{ route('logout') }}" style="margin:.1rem .5rem">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</nav>

<!-- Main -->
<div class="main">
    <div class="topbar">
        <span class="topbar-title">@yield('title', 'Dashboard')</span>
        <div class="topbar-user">
            <i class="fas fa-user-circle" style="color:var(--accent)"></i>
            {{ auth()->user()->name }}
        </div>
    </div>

    <div class="flash-wrap">
        @if(session('success'))<div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
        @if(session('error'))<div class="flash flash-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>@endif
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

<script>
setTimeout(() => document.querySelectorAll('.flash').forEach(el => { el.style.transition='opacity .4s'; el.style.opacity='0'; setTimeout(()=>el.remove(),400); }), 4000);
</script>
@stack('scripts')
</body>
</html>
