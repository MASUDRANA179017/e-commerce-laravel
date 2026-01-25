@extends('layouts.master')

@section('title', 'Trashed Purchase Orders')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Trashed Purchase Orders</h3>
            <a href="{{ route('admin.inventory.purchases') }}" class="btn btn-primary text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i> Back to Purchases
            </a>
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
                                <th>Deleted Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $purchase)
                            <tr class="table-danger opacity-75">
                                <td class="ps-3 fw-medium">{{ $purchase->purchase_number }}</td>
                                <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                                <td>{{ $purchase->items->sum('quantity') }}</td>
                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $purchase->status == 'received' ? 'success' : ($purchase->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                </td>
                                <td>{{ $purchase->deleted_at->format('d M, Y H:i') }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <form action="{{ route('admin.inventory.purchases.restore', $purchase->id) }}" method="POST" class="d-inline-block restore-purchase-form">
                                            @csrf
                                            <button type="submit" class="action-btn-success" title="Restore">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.inventory.purchases.force-delete', $purchase->id) }}" method="POST" class="d-inline-block force-delete-purchase-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn-danger" title="Permanently Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @if($purchase->items->count())
                            <tr class="table-danger opacity-75">
                                <td colspan="7" class="bg-light bg-opacity-25">
                                    <div class="p-2">
                                        <table class="table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Variant</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($purchase->items as $item)
                                                <tr>
                                                    <td>
                                                        <span class="fw-medium">{{ $item->product->title ?? 'Unknown' }}</span>
                                                        <small class="text-muted d-block">{{ $item->product->sku ?? '' }}</small>
                                                    </td>
                                                    <td>
                                                        @if($item->variant)
                                                            @php
                                                                $terms = $item->variant->options->map(function($o){ return $o->term->name ?? null; })->filter()->values()->all();
                                                            @endphp
                                                            <span>{{ implode(', ', $terms) }}</span>
                                                            <small class="text-muted d-block"><code>{{ $item->variant->sku }}</code></small>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>৳{{ number_format($item->unit_cost, 2) }}</td>
                                                    <td class="text-end">৳{{ number_format($item->total_cost, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">delete_sweep</span>
                                        <p class="mb-0">No trashed purchase orders</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($purchases instanceof \Illuminate\Pagination\Paginator || $purchases instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $purchases->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Handle restore forms
    document.querySelectorAll('form.restore-purchase-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (typeof Swal === 'undefined') {
                if (confirm('Are you sure you want to restore this purchase order?')) form.submit();
                return;
            }
            
            Swal.fire({
                title: 'Restore Purchase Order?',
                text: 'This purchase will be restored from trash.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-undo me-2"></i>Yes, restore it!',
                cancelButtonText: '<i class="fas fa-x me-2"></i>Cancel',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    
    // Handle force delete forms
    document.querySelectorAll('form.force-delete-purchase-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (typeof Swal === 'undefined') {
                if (confirm('This will permanently delete the purchase order. This cannot be undone!')) form.submit();
                return;
            }
            
            Swal.fire({
                title: 'Permanently Delete?',
                text: 'This action cannot be undone. The purchase order will be permanently deleted.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash-alt me-2"></i>Yes, delete permanently!',
                cancelButtonText: '<i class="fas fa-x me-2"></i>Cancel',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
