@extends('layouts.app')
@section('title', 'My Profile — PCStore')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-3">My <span>Profile</span></h1>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;align-items:start">
        <!-- Profile Form -->
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:2rem">
            <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;margin-bottom:1.5rem">
                <i class="fas fa-user-edit" style="color:var(--accent)"></i> Account Details
            </h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PUT')
                <div class="grid-2">
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900">
                    </div>
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label">Street Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $user->address) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $user->state) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="zip" class="form-control" value="{{ old('zip', $user->zip) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $user->country) }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-full mt-2">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>

        <div style="display:flex;flex-direction:column;gap:1.5rem">
            <!-- Change Password -->
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:2rem">
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;margin-bottom:1.5rem">
                    <i class="fas fa-lock" style="color:var(--accent)"></i> Change Password
                </h3>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')
                    <!-- Hidden fields to keep other data unchanged -->
                    <input type="hidden" name="name"  value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 characters">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password">
                    </div>
                    <button type="submit" class="btn btn-secondary w-full">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                </form>
            </div>

            <!-- Account Summary -->
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:1.5rem">
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.1rem;margin-bottom:1rem">Account Summary</h3>
                <div style="display:flex;flex-direction:column;gap:.75rem">
                    <div style="display:flex;justify-content:space-between;font-size:.875rem">
                        <span style="color:var(--muted)">Member Since</span>
                        <span>{{ $user->created_at->format('M Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.875rem">
                        <span style="color:var(--muted)">Total Orders</span>
                        <span>{{ $user->orders()->count() }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.875rem">
                        <span style="color:var(--muted)">Total Spent</span>
                        <span style="color:var(--accent)">${{ number_format($user->orders()->where('status','!=','cancelled')->sum('total'), 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.875rem">
                        <span style="color:var(--muted)">Role</span>
                        <span class="badge badge-info">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary w-full mt-3">
                    <i class="fas fa-box"></i> View My Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
