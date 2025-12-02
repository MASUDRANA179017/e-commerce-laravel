@extends('layouts.master')

@section('title', 'Order Returns')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">Order Returns</h3>
                <p class="text-muted mb-0">Manage product returns and refunds</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="create-btn-white">
                <i class="bx bx-arrow-back me-1"></i>Back to Orders
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-1">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(251, 110, 82, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-undo fs-20" style="color: #FB6E52;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">0</h3>
                    <p class="mb-0 fs-13 text-muted">Pending Returns</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-2">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(27, 132, 255, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-package fs-20" style="color: #1B84FF;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">0</h3>
                    <p class="mb-0 fs-13 text-muted">Processing</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-3">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(140, 192, 82, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-check-circle fs-20" style="color: #8CC052;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">0</h3>
                    <p class="mb-0 fs-13 text-muted">Completed</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border: 1px solid rgba(115, 103, 240, 0.2);">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(115, 103, 240, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon" style="background: rgba(115, 103, 240, 0.15);">
                    <i class="bx bx-wallet fs-20" style="color: #7367F0;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">৳0</h3>
                    <p class="mb-0 fs-13 text-muted">Total Refunded</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Returns Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">Return Requests</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search..." style="width: 200px;">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Return ID</th>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-undo bx-lg d-block mb-2" style="color: #d1d5db;"></i>
                                        <p class="mb-0 fw-medium">No return requests found</p>
                                        <small>Return requests will appear here when customers request returns</small>
                                    </div>
                                </td>
                            </tr>
                            <!-- Example Row (Commented out - will show when there's data)
                            <tr>
                                <td class="ps-3">
                                    <span class="fw-bold text-primary">#RET-001</span>
                                </td>
                                <td>
                                    <a href="#" class="text-decoration-none">#ORD-12345</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="wh-36 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                            <span class="text-primary fw-bold">J</span>
                                        </div>
                                        <span class="fw-medium">John Doe</span>
                                    </div>
                                </td>
                                <td>Product Name</td>
                                <td><span class="qbit-badge-gray">Defective</span></td>
                                <td><span class="fw-bold">৳500.00</span></td>
                                <td><span class="qbit-badge-warning"><i class="bx bx-time"></i> Pending</span></td>
                                <td>Dec 01, 2025</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button class="action-btn-info" title="View"><i class="bx bx-show"></i></button>
                                        <button class="action-btn-success" title="Approve"><i class="bx bx-check"></i></button>
                                        <button class="action-btn-danger" title="Reject"><i class="bx bx-x"></i></button>
                                    </div>
                                </td>
                            </tr>
                            -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
