@extends('layouts.master')

@section('title', 'Inventory Reports')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Inventory Reports</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Inventory Reports</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-primary d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-white">inventory_2</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Total Products</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-warning d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-white">warning</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Low Stock</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-danger bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-danger d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-white">error</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Out of Stock</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-success d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-white">check_circle</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">In Stock</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Inventory Status</h5>
                <button class="btn btn-outline-secondary btn-sm">
                    <span class="material-symbols-outlined fs-14">download</span> Export
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>SKU</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

