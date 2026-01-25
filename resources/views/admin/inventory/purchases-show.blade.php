@extends('layouts.master')

@section('title', 'Purchase Order Details')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Purchase Order #{{ $purchase->purchase_number ?? 'N/A' }}</h3>
            <a href="{{ route('admin.inventory.purchases') }}" class="create-btn-white">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Product</th>
                                <th>Ordered</th>
                                <th>Received</th>
                                <th>Unit Cost</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchase->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->product && $item->product->coverImage)
                                            <img src="{{ asset('storage/' . $item->product->coverImage->image_path) }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="bx bx-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="d-block fw-medium">{{ $item->product->title ?? 'Unknown Product' }}</span>
                                            <small class="text-muted">{{ $item->product->sku ?? '' }}</small>
                                            @if($item->variant)
                                                <div class="small text-muted">
                                                    @php
                                                        $variantTerms = $item->variant->options->map(function($opt){ return $opt->term->name ?? null; })->filter()->values()->all();
                                                    @endphp
                                                    @if(!empty($variantTerms))
                                                        <span>{{ implode(', ', $variantTerms) }}</span>
                                                    @endif
                                                    <span> • Stock: {{ $item->variant->stock_quantity }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $purchase->status == 'received' ? $item->quantity : 0 }}</td>
                                <td>৳{{ number_format($item->unit_cost, 2) }}</td>
                                <td class="text-end fw-bold">৳{{ number_format($item->total_cost, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No items found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Vendor Details</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Vendor:</strong> {{ $purchase->vendor->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Contact:</strong> {{ $purchase->vendor->contact_person ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Email:</strong> {{ $purchase->vendor->email ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Phone:</strong> {{ $purchase->vendor->phone ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Status:</span>
                    <span class="badge bg-{{ $purchase->status == 'received' ? 'success' : ($purchase->status == 'cancelled' ? 'danger' : 'warning') }}">
                        {{ ucfirst($purchase->status) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Order Date:</span>
                    <span>{{ $purchase->purchase_date ? $purchase->purchase_date->format('M d, Y') : 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Expected Delivery:</span>
                    <span>{{ $purchase->expected_delivery_date ? $purchase->expected_delivery_date->format('M d, Y') : 'N/A' }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold mb-3">
                    <span>Total:</span>
                    <span>৳{{ number_format($purchase->total_amount, 2) }}</span>
                </div>

                @if($purchase->status != 'received' && $purchase->status != 'cancelled')
                <form action="{{ route('admin.inventory.purchases.update', $purchase->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="received">
                    <button type="submit" class="create-btn-base w-100" onclick="return confirm('Are you sure you want to mark this order as received? This will update stock levels.')">
                        <i class="fas fa-check me-2"></i>Mark as Received
                    </button>
                </form>
                @endif
                
                @if($purchase->status == 'pending')
                <form action="{{ route('admin.inventory.purchases.update', $purchase->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to cancel this order?')">
                        <i class="fas fa-times me-2"></i>Cancel Order
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

