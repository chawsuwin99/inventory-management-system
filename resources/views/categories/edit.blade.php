@extends('layouts')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')

<div class="content-card">

    <h4 class="fw-bold mb-4">Edit Category</h4>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Category Name <span class="text-danger">*</span>
            </label>

            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $category->name) }}"
                   placeholder="Enter category name">

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>

            <textarea name="description"
                      class="form-control"
                      rows="4"
                      placeholder="Enter description">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Status</label>

            <select name="status" class="form-select">
                <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Update Category
        </button>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection