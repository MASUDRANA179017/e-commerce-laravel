@extends('layouts.master')

@section('title', 'Customer Groups')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Customer Groups</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Groups</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Group List</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                    <span class="material-symbols-outlined fs-14">add</span> Add Group
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Group Name</th>
                                <th>Discount</th>
                                <th>Members</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary">Default</span>
                                        <span class="fw-medium">Regular Customers</span>
                                    </div>
                                </td>
                                <td>0%</td>
                                <td>0</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-primary me-1">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-warning">VIP</span>
                                        <span class="fw-medium">VIP Customers</span>
                                    </div>
                                </td>
                                <td>10%</td>
                                <td>0</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-primary me-1">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-info">Wholesale</span>
                                        <span class="fw-medium">Wholesale Buyers</span>
                                    </div>
                                </td>
                                <td>15%</td>
                                <td>0</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-primary me-1">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
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

