@extends('layouts.master')

@section('title', 'Abandoned Carts')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">Abandoned Carts</h3>
                <p class="text-muted mb-0">Track and recover abandoned shopping carts</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="create-btn-white">
                <i class="bx bx-arrow-back me-1"></i>Back to Orders
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-1">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(251, 110, 82, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-cart fs-20" style="color: #FB6E52;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">0</h3>
                    <p class="mb-0 fs-13 text-muted">Abandoned Carts</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-2">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="50" r="40" fill="rgba(27, 132, 255, 0.15)"/>
            </svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-dollar fs-20" style="color: #1B84FF;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">৳0</h3>
                    <p class="mb-0 fs-13 text-muted">Potential Revenue</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
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
                    <p class="mb-0 fs-13 text-muted">Recovered</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Abandoned Carts Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600">Abandoned Cart List</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search..." style="width: 200px;">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Customer</th>
                                <th>Email</th>
                                <th>Items</th>
                                <th>Cart Value</th>
                                <th>Abandoned At</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-cart bx-lg d-block mb-2" style="color: #d1d5db;"></i>
                                        <p class="mb-0 fw-medium">No abandoned carts found</p>
                                        <small>Abandoned carts will appear here when customers leave items in their cart</small>
                                    </div>
                                </td>
                            </tr>
                            <!-- Example Row (Commented out - will show when there's data)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="wh-36 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                            <span class="text-primary fw-bold">J</span>
                                        </div>
                                        <span class="fw-medium">John Doe</span>
                                    </div>
                                </td>
                                <td>john@example.com</td>
                                <td><span class="qbit-badge-info"><i class="bx bx-package"></i> 3 items</span></td>
                                <td><span class="fw-bold">৳1,500.00</span></td>
                                <td>
                                    <span class="text-muted">Dec 01, 2025</span>
                                    <br><small class="text-muted">2 hours ago</small>
                                </td>
                                <td><span class="qbit-badge-warning"><i class="bx bx-time"></i> Not Contacted</span></td>
                                <td class="text-end pe-3">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button class="action-btn-info" title="View Cart"><i class="bx bx-show"></i></button>
                                        <button class="action-btn-primary" title="Send Reminder"><i class="bx bx-mail-send"></i></button>
                                        <button class="action-btn-danger" title="Delete"><i class="bx bx-trash"></i></button>
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
