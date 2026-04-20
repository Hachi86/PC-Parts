@extends('layouts.admin')
@section('title', 'Categories')

@section('content')
<div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start">
    <!-- List -->
    <div>
        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.5rem;margin-bottom:1.25rem">All Categories</h2>
        <div class="card">
            <table class="table">
                <thead>
                    <tr><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td style="font-weight:600">{{ $cat->name }}</td>
                        <td style="color:var(--muted);font-size:.8rem">{{ $cat->slug }}</td>
                        <td>{{ $cat->products_count }}</td>
                        <td>
                            <span class="badge {{ $cat->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $cat->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:.35rem">
                                <!-- Toggle Active -->
                                <form action="{{ route('admin.categories.update', $cat) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="name" value="{{ $cat->name }}">
                                    <input type="hidden" name="is_active" value="{{ $cat->is_active ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-secondary btn-sm" title="Toggle active">
                                        <i class="fas fa-{{ $cat->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                @if($cat->products_count == 0)
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                    onsubmit="return confirm('Delete category?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:2rem">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add New -->
    <div>
        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.5rem;margin-bottom:1.25rem">Add Category</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required placeholder="e.g. Graphics Cards">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Optional description...">{{ old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full"><i class="fas fa-plus"></i> Create Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
