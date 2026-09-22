@extends('layouts.app')
@section('title', 'Register — PCStore')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:440px">
        <div style="text-align:center;margin-bottom:2rem">
            <a href="{{ route('home') }}" style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;color:var(--accent)">PC<span style="color:var(--text)">Store</span></a>
            <h2 style="margin-top:.75rem;font-size:1.5rem">Create account</h2>
            <p style="color:var(--muted);font-size:.9rem;margin-top:.25rem">Join thousands of builders</p>
        </div>

        <div style="background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:2rem">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required placeholder="John Doe">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required placeholder="you@example.com">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Min. 8 characters">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat password">
                </div>
                <button type="submit" class="btn btn-primary w-full btn-lg">Create Account</button>
            </form>
            <div style="text-align:center;margin-top:1.25rem;font-size:.875rem;color:var(--muted)">
                Already have an account? <a href="{{ route('login') }}" style="color:var(--accent)">Sign in</a>
            </div>
        </div>
    </div>
</div>
@endsection
