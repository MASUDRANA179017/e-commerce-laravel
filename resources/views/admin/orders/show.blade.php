@extends('layouts.master')

@section('title', 'Order Details')

@push('styles')
<style>
    .order-timeline {
        position: relative;
        padding-left: 30px;
    }
    .order-timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -26px;
        top: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--qbit-primary);
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px var(--qbit-primary-20);
    }
    .timeline-item.completed::before {
        background: var(--qbit-success);
        box-shadow: 0 0 0 2px var(--qbit-success-20);
    }
    .product-thumb {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        background: #f3f4f6;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">Order #{{ $order->order_number }}</h3>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                    @php
                        $statusClass = match($order->status) {
                            'pending' => 'warning',
                            'processing' => 'info',
                            'shipped' => 'primary',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                            default => 'gray'
                        };
                    @endphp
                    <span class="qbit-badge-{{ $statusClass }}">
                        <i class="bx bx-{{ $order->status == 'delivered' ? 'check-circle' : 'time-five' }}"></i>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="create-btn-white">
                    <i class="bx bx-arrow-back me-1"></i>Back
                </a>
                <a href="{{ route('admin.orders.invoice', $order->id) }}" class="create-btn-white">
                    <i class="bx bx-receipt me-1"></i>Invoice
                </a>
                <a href="{{ route('admin.orders.print', $order->id) }}" class="create-btn-base" target="_blank">
                    <i class="bx bx-printer me-1"></i>Print
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Order Items -->
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">
                    <i class="bx bx-package me-2"></i>Order Items ({{ $order->items->count() }})
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end pe-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($item->product && $item->product->coverImage)
                                            <img src="{{ asset('storage/' . $item->product->coverImage->path) }}" class="product-thumb" alt="{{ $item->product_name }}">
                                        @else
                                            <div class="product-thumb d-flex align-items-center justify-content-center">
                                                <i class="bx bx-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="fw-medium d-block">{{ $item->product_name }}</span>
                                            @if($item->variant_name)
                                                <small class="text-muted">{{ $item->variant_name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>৳{{ number_format($item->price, 2) }}</td>
                                <td>
                                    <span class="qbit-badge-gray">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-end pe-3 fw-bold">৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No items in this order</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">
                    <i class="bx bx-map me-2"></i>Shipping Address
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-1 fw-medium">{{ $order->full_name }}</p>
                <p class="mb-1 text-muted">{{ $order->address }}</p>
                @if($order->address2)
                    <p class="mb-1 text-muted">{{ $order->address2 }}</p>
                @endif
                <p class="mb-1 text-muted">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                <p class="mb-0 text-muted">{{ $order->country }}</p>
            </div>
        </div>

        @if($order->notes)
        <!-- Order Notes -->
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">
                    <i class="bx bx-note me-2"></i>Order Notes
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0 text-muted">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Customer Details -->
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">
                    <i class="bx bx-user me-2"></i>Customer Details
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="wh-50 rounded-circle d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--qbit-primary) 0%, var(--qbit-purple) 100%);">
                        <span class="text-white fw-bold fs-5">{{ strtoupper(substr($order->first_name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <span class="fw-bold d-block">{{ $order->full_name }}</span>
                        @if($order->user)
                            <small class="text-muted">Registered Customer</small>
                        @else
                            <small class="text-muted">Guest Customer</small>
                        @endif
                    </div>
                </div>
                <div class="border-top pt-3">
                    <p class="mb-2 d-flex align-items-center gap-2">
                        <i class="bx bx-envelope text-muted"></i>
                        <a href="mailto:{{ $order->email }}" class="text-decoration-none">{{ $order->email }}</a>
                    </p>
                    @if($order->phone)
                    <p class="mb-0 d-flex align-items-center gap-2">
                        <i class="bx bx-phone text-muted"></i>
                        <a href="tel:{{ $order->phone }}" class="text-decoration-none">{{ $order->phone }}</a>
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Update Order Status -->
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">
                    <i class="bx bx-refresh me-2"></i>Update Status
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" id="statusForm">
                    @csrf
                    <select class="form-select mb-3" name="status" id="orderStatus">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>Returned</option>
                    </select>
                    <button type="submit" class="create-btn-base w-100">
                        <i class="bx bx-check me-1"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">
                    <i class="bx bx-credit-card me-2"></i>Payment Info
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Method:</span>
                    <span class="fw-medium text-capitalize">{{ $order->payment_method ?? 'Cash on Delivery' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Status:</span>
                    @if($order->payment_status == 'paid')
                        <span class="qbit-badge-success"><i class="bx bx-check"></i> Paid</span>
                    @else
                        <span class="qbit-badge-warning"><i class="bx bx-time"></i> {{ ucfirst($order->payment_status ?? 'Pending') }}</span>
                    @endif
                </div>
                @if($order->transaction_id)
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Transaction ID:</span>
                    <code>{{ $order->transaction_id }}</code>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">
                    <i class="bx bx-calculator me-2"></i>Order Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal:</span>
                    <span>৳{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Discount:</span>
                    <span class="text-success">-৳{{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Shipping:</span>
                    <span>৳{{ number_format($order->shipping ?? 0, 2) }}</span>
                </div>
                @if($order->tax > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tax:</span>
                    <span>৳{{ number_format($order->tax, 2) }}</span>
                </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total:</span>
                    <span class="text-primary">৳{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('statusForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const status = document.getElementById('orderStatus').value;
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: data.message || 'Order status updated successfully',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to update order status'
        });
    });
});
</script>
@endpush
