@extends('layouts.master')

@section('title', 'Purchase Order Details')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Purchase Order #{{ $purchase ?? 'N/A' }}</h3>
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
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No items</td>
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
                <h5 class="mb-0 fw-bold">Vendor Details</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Vendor:</strong> N/A</p>
                <p class="mb-1"><strong>Contact:</strong> N/A</p>
                <p class="mb-0"><strong>Email:</strong> N/A</p>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Status:</span>
                    <span class="qbit-badge-warning"><i class="bx bx-time"></i> Pending</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Order Date:</span>
                    <span>{{ now()->format('M d, Y') }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total:</span>
                    <span>৳0.00</span>
                </div>
                <button class="create-btn-base w-100 mt-3">
                    <i class="fas fa-check me-2"></i>Mark as Received
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

