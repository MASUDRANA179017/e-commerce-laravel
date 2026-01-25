@extends('layouts.master')

@section('title', 'Purchase Orders')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Purchase Orders</h3>
            <div class="d-flex gap-2">
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
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('admin.inventory.purchases.show', $purchase->id) }}" class="action-btn-success" title="Edit">
                                            <i class="fas fa-edit"></i>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    document.querySelectorAll('form[action*="inventory/purchases/"][method="post"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var action = form.getAttribute('action');
            var methodInput = form.querySelector('input[name="_method"]');
            var method = methodInput ? methodInput.value.toUpperCase() : 'POST';
            if (typeof Swal === 'undefined') {
                if (confirm('Are you sure?')) form.submit();
                return;
            }
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel'
            }).then(function(res) {
                if (!res.isConfirmed) return;
                fetch(action, {
                    method: method === 'DELETE' ? 'DELETE' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: method === 'DELETE' ? null : new FormData(form)
                }).then(function(resp) {
                    if (resp.ok) {
                        Swal.fire({icon:'success', title:'Done', text:'Operation completed', timer:1500, showConfirmButton:false})
                            .then(function(){ window.location.reload(); });
                    } else {
                        resp.json().then(function(j){
                            Swal.fire('Error', j.message || 'Failed to perform action', 'error');
                        }).catch(function(){
                            Swal.fire('Error', 'Failed to perform action', 'error');
                        });
                    }
                }).catch(function(){
                    Swal.fire('Error', 'Network error', 'error');
                });
            });
        });
    });
});
</script>
@endpush
@endsection
