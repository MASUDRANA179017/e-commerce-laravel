@extends('layouts.master')

@section('title', 'All Orders')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">All Orders</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Order Stats -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-warning">pending</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Pending</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Processing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-success">check_circle</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Completed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-danger">cancel</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Cancelled</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5 class="mb-0 fw-bold">Order List</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <input type="date" class="form-control form-control-sm" style="width: auto;">
                    <button class="btn btn-primary btn-sm">
                        <span class="material-symbols-outlined fs-14">filter_list</span> Filter
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="ordersTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Products</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">shopping_cart</span>
                                        <p class="mb-0">No orders found</p>
                                        <small>Orders will appear here when customers make purchases</small>
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

