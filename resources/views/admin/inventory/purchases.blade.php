@extends('layouts.master')

@section('title', 'Purchase Orders')

@section('content')
<div class="row">
    <div class="mb-4 col-12">
        <div class="flex-wrap gap-3 d-flex align-items-center justify-content-between">
            <h3 class="mb-0 fw-bold">Purchase Orders</h3>
            <div class="gap-2 d-flex">
                <a href="{{ route('admin.inventory.purchases.trash') }}" class="btn btn-warning text-decoration-none">
                    <i class="fas fa-trash me-2"></i> Trash
                </a>
                <a href="{{ route('admin.inventory.purchases.create') }}" class="create-btn-base text-decoration-none">
                    <span class="material-symbols-outlined fs-14">add</span> Create Purchase Order
                </a>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="border-0 card">
            <div class="p-0 card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-hover">
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
                                    <div class="gap-1 d-inline-flex align-items-center">
                                        <a href="{{ route('admin.inventory.purchases.show', $purchase->id) }}" class="action-btn-success" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($purchase->status !== 'received' && $purchase->status !== 'cancelled')
                                        <form action="{{ route('admin.inventory.purchases.update', $purchase->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="received">
                                            <button type="submit" class="action-btn-info" title="Mark as Received">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('admin.inventory.purchases.destroy', $purchase->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @if($purchase->items->count())
                            <tr>
                                <td colspan="7" class="bg-opacity-25 bg-light">
                                    <div class="p-2">
                                        <table class="table mb-0 table-sm">
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
                                <td colspan="7" class="py-5 text-center">
                                    <div class="text-muted">
                                        <span class="mb-2 material-symbols-outlined fs-1 d-block">receipt_long</span>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Handle delete forms specifically
    document.querySelectorAll('.delete-purchase-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var action = form.action; // Use property for full URL

            if (typeof Swal === 'undefined') {
                if (confirm('Are you sure?')) form.submit();
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then(function(res) {
                if (!res.isConfirmed) return;

                fetch(action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).then(function(resp) {
                    if (resp.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Purchase order has been deleted.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function(){
                            window.location.reload();
                        });
                    } else {
                        resp.json().then(function(j){
                            Swal.fire('Error', j.message || 'Failed to delete', 'error');
                        }).catch(function(){
                            Swal.fire('Error', 'Failed to delete', 'error');
                        });
                    }
                }).catch(function(){
                    Swal.fire('Error', 'Network error', 'error');
                });
            });
        });
    });

    // Handle other post forms if necessary (excluding delete forms)
    document.querySelectorAll('form[action*="inventory/purchases/"][method="post"]:not(.delete-purchase-form)').forEach(function(form) {

});
</script>
@endpush
@endsection
