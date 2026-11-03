
@extends('layouts')

@section('title', 'Reports')

@section('page-title', 'Inventory Reports')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Inventory Reports</h3>
            <p class="text-muted mb-0">
                Monitor your inventory performance and stock movements.
            </p>
        </div>

        <div class="d-flex gap-2">
        <a href="{{ route('reports.export', request()->query()) }}"
        class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export CSV
        </a>

        <button onclick="window.print()" class="btn btn-dark">
            <i class="bi bi-printer"></i> Print Report
        </button>
    </div>
    </div>

    {{-- Date Filter --}}
    <div class="content-card mb-4">
        <h5 class="fw-bold mb-3">Filter by Date</h5>

        <form action="{{ route('reports.index') }}" method="GET">
            <div class="row align-items-end">

                <div class="col-md-4 mb-3">
                    <label class="form-label">From Date</label>
                    <input type="date"
                           name="date_from"
                           class="form-control"
                           value="{{ $dateFrom }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">To Date</label>
                    <input type="date"
                           name="date_to"
                           class="form-control"
                           value="{{ $dateTo }}">
                </div>

                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary">
                        Apply Filter
                    </button>

                    <a href="{{ route('reports.index') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Products</p>
                    <h3 class="fw-bold">{{ number_format($totalProducts) }}</h3>
                    <small class="text-primary">Registered Products</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Stock IN</p>
                    <h3 class="fw-bold text-success">
                        +{{ number_format($totalStockIn) }}
                    </h3>
                    <small class="text-muted">Total Quantity Received</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Stock OUT</p>
                    <h3 class="fw-bold text-danger">
                        -{{ number_format($totalStockOut) }}
                    </h3>
                    <small class="text-muted">Total Quantity Issued</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Transactions</p>
                    <h3 class="fw-bold">
                        {{ number_format($totalTransactions) }}
                    </h3>
                    <small class="text-muted">Recorded Movements</small>
                </div>
            </div>
        </div>

    </div>

    {{-- Stock Information --}}
    <div class="row mb-4">

        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Current Stock Value</p>
                    <h3 class="fw-bold text-primary">
                        {{ number_format($totalStockValue, 2) }} MMK
                    </h3>
                    <small class="text-muted">
                        Based on purchase price
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Low Stock Products</p>
                    <h3 class="fw-bold text-warning">
                        {{ number_format($lowStockProducts) }}
                    </h3>
                    <small class="text-muted">
                        Products requiring restocking
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- Transaction Table --}}
    <div class="content-card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Stock Transaction Details</h5>
            <span class="badge bg-primary">
                {{ $transactions->total() }} Records
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>

                            <td class="fw-semibold">
                                {{ $transaction->product->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $transaction->product->sku ?? 'N/A' }}
                            </td>

                            <td>
                                @if($transaction->type === 'in')
                                    <span class="badge bg-success">STOCK IN</span>
                                @else
                                    <span class="badge bg-danger">STOCK OUT</span>
                                @endif
                            </td>

                            <td class="fw-semibold">
                                {{ number_format($transaction->quantity) }}
                            </td>

                            <td>
                                {{ number_format($transaction->unit_price, 2) }} MMK
                            </td>

                            <td>
                                {{ $transaction->user->name ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $transactions->links() }}
        </div>

    </div>

</div>

@endsection
