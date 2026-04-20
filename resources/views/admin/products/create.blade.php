@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.5rem">{{ isset($product) ? 'Edit: '.$product->name : 'Add New Product' }}</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
        <!-- Main -->
        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="card">
                <div class="card-header"><h3>Basic Information</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Description</label>
                        <input type="text" name="short_description" class="form-control"
                            value="{{ old('short_description', $product->short_description ?? '') }}" maxlength="500">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Full Description *</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3>Pricing & Stock</h3></div>
                <div class="card-body">
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Regular Price ($) *</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sale Price ($)</label>
                            <input type="number" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror"
                                value="{{ old('sale_price', $product->sale_price ?? '') }}" step="0.01" min="0">
                            @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock Quantity *</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">SKU *</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                value="{{ old('sku', $product->sku ?? '') }}" required>
                            @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Brand</label>
                            <input type="text" name="brand" class="form-control"
                                value="{{ old('brand', $product->brand ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="card">
                <div class="card-header"><h3>Status</h3></div>
                <div class="card-body">
                    <div style="display:flex;flex-direction:column;gap:.75rem">
                        <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer;font-size:.875rem">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} style="accent-color:var(--accent)">
                            <span>Active (visible in store)</span>
                        </label>
                        <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer;font-size:.875rem">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--accent)">
                            <span>Featured product</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3>Product Image</h3></div>
                <div class="card-body">
                    @if(isset($product) && $product->image)
                        <div style="margin-bottom:.75rem">
                            <img src="{{ $product->image_url }}" alt="" style="width:100%;border-radius:8px;border:1px solid var(--border)">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <p style="font-size:.75rem;color:var(--muted);margin-top:.35rem">Max 2MB. JPG, PNG, WebP.</p>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:.5rem">
                <button type="submit" class="btn btn-primary w-full">
                    <i class="fas fa-save"></i> {{ isset($product) ? 'Update Product' : 'Create Product' }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-full">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
