@extends('layouts.master')

@section('title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">Order #{{ $order ?? 'N/A' }}</h3>
                <p class="text-muted mb-0">Order placed on {{ now()->format('M d, Y') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
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
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Order details not available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Customer Details</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> N/A</p>
                <p class="mb-1"><strong>Email:</strong> N/A</p>
                <p class="mb-1"><strong>Phone:</strong> N/A</p>
                <p class="mb-0"><strong>Address:</strong> N/A</p>
            </div>
        </div>

        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order Status</h5>
            </div>
            <div class="card-body">
                <select class="form-select mb-3">
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Shipped</option>
                    <option>Delivered</option>
                    <option>Cancelled</option>
                </select>
                <button class="btn btn-primary w-100">Update Status</button>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>৳0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping:</span>
                    <span>৳0.00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total:</span>
                    <span>৳0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

