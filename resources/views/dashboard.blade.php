@extends('layouts')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold">Welcome to Inventory Pro</h4>
    <p class="text-muted">Manage your inventory efficiently.</p>
</div>

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="content-card">
            <p class="text-muted mb-2">Total Products</p>
            <h3 class="fw-bold">{{ $totalProducts }}</h3>
            <i class="bi bi-box-seam text-primary"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="content-card">
            <p class="text-muted mb-2">Total Categories</p>
            <h3 class="fw-bold">{{ $totalCategories }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="content-card">
            <p class="text-muted mb-2">Total Suppliers</p>
            <h3 class="fw-bold">{{ $totalSuppliers }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="content-card">
            <p class="text-muted mb-2">Total Stock Value</p>
            <h3 class="fw-bold">
                {{ number_format($totalStockValue) }} MMK
            </h3>
        </div>
    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-md-6">
        <div class="content-card">
            <h5>Stock IN</h5>
            <h3 class="text-success fw-bold">
                {{ number_format($totalStockIn) }}
            </h3>
        </div>
    </div>

    <div class="col-md-6">
        <div class="content-card">
            <h5>Stock OUT</h5>
            <h3 class="text-danger fw-bold">
                {{ number_format($totalStockOut) }}
            </h3>
        </div>
    </div>

</div>

<div class="content-card mb-4">
    <h5 class="fw-bold mb-3">Low Stock Alerts</h5>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Minimum Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="text-danger fw-bold">
                            {{ $product->quantity }} {{ $product->unit }}
                        </td>
                        <td>{{ $product->min_stock_level }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No low stock products.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="content-card">
    <h5 class="fw-bold mb-3">Recent Stock Transactions</h5>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Recorded By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                        <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                        <td>
                            @if($transaction->type === 'in')
                                <span class="badge bg-success">IN</span>
                            @else
                                <span class="badge bg-danger">OUT</span>
                            @endif
                        </td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No transactions yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
