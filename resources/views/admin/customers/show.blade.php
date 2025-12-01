@extends('layouts.master')

@section('title', 'Customer Details')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Customer Details</h3>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Customers
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4">
            <div class="card-body text-center">
                <div class="wh-100 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3">
                    <span class="text-primary fw-bold fs-1">{{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}</span>
                </div>
                <h5 class="fw-bold mb-1">{{ $customer->name ?? 'N/A' }}</h5>
                <p class="text-muted mb-3">{{ $customer->email ?? 'N/A' }}</p>
                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Full Name</label>
                        <p class="fw-medium mb-0">{{ $customer->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="fw-medium mb-0">{{ $customer->email ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Phone</label>
                        <p class="fw-medium mb-0">{{ $customer->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Joined Date</label>
                        <p class="fw-medium mb-0">{{ $customer->created_at->format('M d, Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order History</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No orders found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

