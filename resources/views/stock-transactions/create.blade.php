@extends('layouts')

@section('title', 'New Stock Transaction')
@section('page-title', 'New Stock Transaction')

@section('content')

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Record Stock Transaction</h4>

        <a href="{{ route('stock-transactions.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stock-transactions.store') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Product <span class="text-danger">*</span></label>

                <select name="product_id" class="form-select" required>
                    <option value="">Select Product</option>

                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ $product->sku }})
                            - Available: {{ $product->quantity }} {{ $product->unit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Transaction Type <span class="text-danger">*</span></label>

                <select name="type" class="form-select" required>
                    <option value="">Select Type</option>
                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>
                        Stock IN
                    </option>
                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>
                        Stock OUT
                    </option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number"
                       name="quantity"
                       class="form-control"
                       min="1"
                       value="{{ old('quantity') }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Unit Price <span class="text-danger">*</span></label>
                <input type="number"
                       name="unit_price"
                       class="form-control"
                       min="0"
                       step="0.01"
                       value="{{ old('unit_price', 0) }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Transaction Date <span class="text-danger">*</span></label>
                <input type="datetime-local"
                       name="transaction_date"
                       class="form-control"
                       value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}"
                       required>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Note</label>
                <textarea name="note"
                          class="form-control"
                          rows="3"
                          placeholder="Enter transaction details...">{{ old('note') }}</textarea>
            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('stock-transactions.index') }}" class="btn btn-light">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                Save Transaction
            </button>
        </div>

    </form>

</div>

@endsection