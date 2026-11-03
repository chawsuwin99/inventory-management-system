@extends('layouts')

@section('title', 'Stock Transactions')
@section('page-title', 'Stock Transactions')

@section('content')

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Stock Transaction History</h4>

        <a href="{{ route('stock-transactions.create') }}" class="btn btn-primary">
            + New Transaction
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Recorded By</th>
                    <th>Note</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transactions->firstItem() + $loop->index }}</td>

                        <td>{{ $transaction->transaction_date->format('d M Y H:i') }}</td>

                        <td>{{ $transaction->product->name }}</td>

                        <td>{{ $transaction->product->sku }}</td>

                        <td>
                            @if($transaction->type === 'in')
                                <span class="badge bg-success">Stock IN</span>
                            @else
                                <span class="badge bg-danger">Stock OUT</span>
                            @endif
                        </td>

                        <td>{{ number_format($transaction->quantity) }}</td>

                        <td>{{ number_format($transaction->unit_price, 2) }}</td>

                        <td>{{ $transaction->user->name ?? 'N/A' }}</td>

                        <td>{{ $transaction->note ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No stock transactions found.
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

@endsection