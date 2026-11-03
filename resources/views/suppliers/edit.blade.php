@extends('layouts')

@section('title', 'Edit Supplier')
@section('page-title', 'Edit Supplier')

@section('content')

<div class="content-card">

    <h4 class="fw-bold mb-4">Edit Supplier</h4>

    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Supplier Name *</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $supplier->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Company Name</label>
                <input type="text" name="company_name"
                       class="form-control"
                       value="{{ old('company_name', $supplier->company_name) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone"
                       class="form-control"
                       value="{{ old('phone', $supplier->phone) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $supplier->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control"
                          rows="3">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control"
                          rows="3">{{ old('description', $supplier->description) }}</textarea>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="1" {{ old('status', (string) $supplier->status) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', (string) $supplier->status) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Update Supplier
        </button>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection