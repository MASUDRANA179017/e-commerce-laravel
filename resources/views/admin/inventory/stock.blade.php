@extends('layouts.master')

@section('title', 'Stock Management')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Stock Management</h3>
            <div class="d-flex gap-2">
                <button class="create-btn-white">
                    <span class="material-symbols-outlined fs-14">download</span> Export
                </button>
                <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#adjustStockModal">
                    <span class="material-symbols-outlined fs-14">tune</span> Adjust Stock
                </button>
            </div>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="in_stock">In Stock</option>
                            <option value="low_stock">Low Stock</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" placeholder="Search products..." style="width: 200px;">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>SKU</th>
                                <th>Current Stock</th>
                                <th>Reserved</th>
                                <th>Available</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="wh-40 rounded bg-light overflow-hidden">
                                            @if($product->coverImage)
                                                <img src="{{ asset('storage/' . $product->coverImage->image) }}" class="w-100 h-100 object-fit-cover">
                                            @endif
                                        </div>
                                        <span class="fw-medium">{{ Str::limit($product->name, 30) }}</span>
                                    </div>
                                </td>
                                <td><code>{{ $product->sku ?? '-' }}</code></td>
                                <td>{{ $product->stock ?? 0 }}</td>
                                <td>0</td>
                                <td>{{ $product->stock ?? 0 }}</td>
                                <td>
                                    @if(($product->stock ?? 0) > 10)
                                        <span class="qbit-badge-success"><i class="bx bx-check-circle"></i> In Stock</span>
                                    @elseif(($product->stock ?? 0) > 0)
                                        <span class="qbit-badge-warning"><i class="bx bx-error"></i> Low Stock</span>
                                    @else
                                        <span class="qbit-badge-danger"><i class="bx bx-x-circle"></i> Out of Stock</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-info">Adjust</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No products found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(isset($products) && $products->hasPages())
            <div class="card-footer bg-white">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Adjust Stock Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Adjust Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select class="form-select">
                            <option>Select Product</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Adjustment Type</label>
                            <select class="form-select">
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                                <option value="set">Set to</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" rows="2" placeholder="Optional note..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="create-btn-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="create-btn-base">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

