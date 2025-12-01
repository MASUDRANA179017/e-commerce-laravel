@extends('layouts.master')

@section('title', 'Returns & RMAs')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Returns & RMAs</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">Returns</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Return Requests</h5>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">RMA ID</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Request Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">assignment_return</span>
                                        <p class="mb-0">No return requests found</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

