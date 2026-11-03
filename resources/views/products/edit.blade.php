@extends('layouts')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')

<div class="content-card">

    <h4 class="fw-bold mb-4">Edit Product</h4>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Product Name *</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">SKU *</label>
                <input type="text" name="sku"
                       class="form-control @error('sku') is-invalid @enderror"
                       value="{{ old('sku', $product->sku) }}">
                @error('sku')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Category *</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Unit *</label>
                <select name="unit" class="form-select">
                    @foreach(['pcs', 'box', 'kg', 'liter', 'pack'] as $unit)
                        <option value="{{ $unit }}"
                            {{ old('unit', $product->unit) == $unit ? 'selected' : '' }}>
                            {{ $unit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Purchase Price *</label>
                <input type="number" name="purchase_price"
                       class="form-control"
                       value="{{ old('purchase_price', $product->purchase_price) }}"
                       min="0" step="0.01">
                @error('purchase_price')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Selling Price *</label>
                <input type="number" name="selling_price"
                       class="form-control"
                       value="{{ old('selling_price', $product->selling_price) }}"
                       min="0" step="0.01">
                @error('selling_price')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Current Stock</label>
            <input type="text"
                class="form-control"
                value="{{ $product->quantity }} {{ $product->unit }}"
                readonly>
            <small class="text-muted">
                Stock quantity can only be changed through Stock IN / OUT.
            </small>
        </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Minimum Stock Level *</label>
                <input type="number" name="min_stock_level"
                       class="form-control"
                       value="{{ old('min_stock_level', $product->min_stock_level) }}"
                       min="0">
                @error('min_stock_level')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-12 mb-4">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control"
                          rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Update Product
        </button>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection