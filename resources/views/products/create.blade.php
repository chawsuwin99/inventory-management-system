@extends('layouts')

@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('content')

<div class="content-card">

    <h4 class="fw-bold mb-4">Add New Product</h4>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Product Name *</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Enter product name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">SKU *</label>
                <input type="text" name="sku"
                       class="form-control @error('sku') is-invalid @enderror"
                       value="{{ old('sku') }}"
                       placeholder="Example: PRD-001">
                @error('sku')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Category *</label>
                <select name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Unit *</label>
                <select name="unit" class="form-select">
                    <option value="pcs" {{ old('unit', 'pcs') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                    <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                    <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                    <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>Liter</option>
                    <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Purchase Price *</label>
                <input type="number" name="purchase_price"
                       class="form-control @error('purchase_price') is-invalid @enderror"
                       value="{{ old('purchase_price', 0) }}"
                       min="0" step="0.01">
                @error('purchase_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Selling Price *</label>
                <input type="number" name="selling_price"
                       class="form-control @error('selling_price') is-invalid @enderror"
                       value="{{ old('selling_price', 0) }}"
                       min="0" step="0.01">
                @error('selling_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Quantity *</label>
                <input type="number" name="quantity"
                       class="form-control @error('quantity') is-invalid @enderror"
                       value="{{ old('quantity', 0) }}"
                       min="0">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Minimum Stock Level *</label>
                <input type="number" name="min_stock_level"
                       class="form-control @error('min_stock_level') is-invalid @enderror"
                       value="{{ old('min_stock_level', 5) }}"
                       min="0">
                @error('min_stock_level')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-12 mb-4">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control"
                          rows="4"
                          placeholder="Enter product description">{{ old('description') }}</textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Save Product
        </button>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection