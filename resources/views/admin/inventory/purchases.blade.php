@extends('layouts.master')

@section('title', 'Purchase Orders')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Purchase Orders</h3>
            <button class="create-btn-base">
                <span class="material-symbols-outlined fs-14">add</span> Create Purchase Order
            </button>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">PO Number</th>
                                <th>Vendor</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Expected Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $purchase)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $purchase->purchase_number }}</td>
                                <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                                <td>{{ $purchase->items->sum('quantity') }}</td>
                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $purchase->status == 'received' ? 'success' : ($purchase->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                </td>
                                <td>{{ $purchase->expected_delivery_date ? $purchase->expected_delivery_date->format('d M, Y') : 'N/A' }}</td>
                                <td class="text-end pe-3">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                            <li><a class="dropdown-item" href="{{ route('admin.inventory.purchases.show', $purchase->id) }}"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                            <li>
                                                <form action="{{ route('admin.inventory.purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">receipt_long</span>
                                        <p class="mb-0">No purchase orders found</p>
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

