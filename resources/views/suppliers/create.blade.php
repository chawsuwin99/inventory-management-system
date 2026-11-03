@extends('layouts')

@section('title', 'Add Supplier')
@section('page-title', 'Add Supplier')

@section('content')

<div class="content-card">

    <h4 class="fw-bold mb-4">Add New Supplier</h4>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Supplier Name *</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Enter supplier name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Company Name</label>
                <input type="text" name="company_name"
                       class="form-control"
                       value="{{ old('company_name') }}"
                       placeholder="Enter company name">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone"
                       class="form-control"
                       value="{{ old('phone') }}"
                       placeholder="Enter phone number">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="Enter email address">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control"
                          rows="3"
                          placeholder="Enter supplier address">{{ old('address') }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control"
                          rows="3"
                          placeholder="Enter description">{{ old('description') }}</textarea>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Save Supplier
        </button>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection