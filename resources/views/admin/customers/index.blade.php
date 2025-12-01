@extends('layouts.master')

@section('title', 'All Customers')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">All Customers</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-primary">group</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $customers->total() ?? 0 }}</h4>
                        <span class="text-muted">Total Customers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-success">person_add</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">New This Month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-info">shopping_cart</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">With Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5 class="mb-0 fw-bold">Customer List</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search customers..." style="width: 200px;">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <span class="material-symbols-outlined fs-14">add</span> Add Customer
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers ?? [] as $customer)
                            <tr>
                                <td class="ps-3">
                                    <input type="checkbox" class="form-check-input">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="wh-40 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                            <span class="text-primary fw-bold">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                        </div>
                                        <span class="fw-medium">{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td>0</td>
                                <td>৳0.00</td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                </td>
                                <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">group</span>
                                        <p class="mb-0">No customers found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(isset($customers) && $customers->hasPages())
            <div class="card-footer bg-white">
                {{ $customers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

