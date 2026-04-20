@extends('layouts.app')
@section('title', 'Login — PCStore')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:420px">
        <div style="text-align:center;margin-bottom:2rem">
            <a href="{{ route('home') }}" style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;color:var(--accent)">PC<span style="color:var(--text)">Store</span></a>
            <h2 style="margin-top:.75rem;font-size:1.5rem">Welcome back</h2>
            <p style="color:var(--muted);font-size:.9rem;margin-top:.25rem">Sign in to your account</p>
        </div>

        <div style="background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:2rem">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="font-size:.875rem;color:var(--muted);cursor:pointer">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary w-full btn-lg">Sign In</button>
            </form>

            <div style="text-align:center;margin-top:1.25rem;font-size:.875rem;color:var(--muted)">
                Don't have an account? <a href="{{ route('register') }}" style="color:var(--accent)">Create one</a>
            </div>

            <div style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:1rem;margin-top:1.25rem;font-size:.8rem;color:var(--muted)">
                <p><strong style="color:var(--text)">Demo Admin:</strong> admin@pcstore.com / password</p>
                <p class="mt-1"><strong style="color:var(--text)">Demo Customer:</strong> john@example.com / password</p>
            </div>
        </div>
    </div>
</div>
@endsection
