@extends('layouts')

@section('title', 'Products')
@section('page-title', 'Product Management')

@section('content')

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Products</h4>
            <p class="text-muted mb-0">Manage your inventory products</p>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Purchase Price</th>
                    <th>Selling Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>

                        <td class="fw-semibold">
                            {{ $product->name }}
                        </td>

                        <td>{{ $product->sku }}</td>

                        <td>{{ $product->category->name }}</td>

                        <td>{{ number_format($product->purchase_price, 2) }}</td>

                        <td>{{ number_format($product->selling_price, 2) }}</td>

                        <td>
                            @if($product->quantity <= $product->min_stock_level)
                                <span class="badge bg-danger">
                                    {{ $product->quantity }} {{ $product->unit }}
                                </span>
                            @else
                                <span class="badge bg-success">
                                    {{ $product->quantity }} {{ $product->unit }}
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($product->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('products.edit', $product) }}"
                               class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('products.destroy', $product) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No products found. Please add your first product.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>

</div>

@endsection