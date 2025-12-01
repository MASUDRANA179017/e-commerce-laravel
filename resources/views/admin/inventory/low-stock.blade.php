@extends('layouts.master')

@section('title', 'Low Stock Products')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Low Stock Products</h3>
            <a href="{{ route('admin.inventory.stock') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Stock
            </a>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-warning bg-opacity-10">
                <h5 class="mb-0 fw-bold text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Products with Low Stock (< 10 units)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>SKU</th>
                                <th>Current Stock</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                            <tr>
                                <td class="ps-3">{{ $product->name ?? $product->title ?? 'N/A' }}</td>
                                <td><code>{{ $product->sku ?? '-' }}</code></td>
                                <td>
                                    <span class="badge bg-{{ ($product->stock ?? 0) == 0 ? 'danger' : 'warning' }}">
                                        {{ $product->stock ?? 0 }} units
                                    </span>
                                </td>
                                <td>
                                    @if(($product->stock ?? 0) == 0)
                                        <span class="badge bg-danger bg-opacity-10 text-danger">Out of Stock</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning">Low Stock</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-warning">Restock</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-success">
                                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                                        <p class="mb-0">All products are well stocked!</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

