@extends('layouts.master')

@section('title', 'Sales Reports')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Sales Reports</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sales Reports</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1">Total Sales</span>
                        <h4 class="fw-bold mb-0 text-primary">৳0.00</h4>
                    </div>
                    <span class="material-symbols-outlined fs-1 text-primary opacity-50">payments</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1">Total Orders</span>
                        <h4 class="fw-bold mb-0 text-success">0</h4>
                    </div>
                    <span class="material-symbols-outlined fs-1 text-success opacity-50">shopping_cart</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-info bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1">Avg Order Value</span>
                        <h4 class="fw-bold mb-0 text-info">৳0.00</h4>
                    </div>
                    <span class="material-symbols-outlined fs-1 text-info opacity-50">trending_up</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0 bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1">Products Sold</span>
                        <h4 class="fw-bold mb-0 text-warning">0</h4>
                    </div>
                    <span class="material-symbols-outlined fs-1 text-warning opacity-50">inventory_2</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="col-12 mb-4">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Sales Overview</h5>
                <div class="d-flex gap-2">
                    <input type="date" class="form-control form-control-sm">
                    <input type="date" class="form-control form-control-sm">
                    <button class="create-btn-base">Apply</button>
                    <button class="select-btn-info">
                        <span class="material-symbols-outlined fs-14">download</span> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="salesChart" style="height: 400px;"></div>
            </div>
        </div>
    </div>

    <!-- Top Products & Categories -->
    <div class="col-xl-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Top Selling Products</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Top Categories</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Category</th>
                                <th>Products Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var options = {
        series: [{
            name: 'Sales',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        }],
        chart: {
            type: 'area',
            height: 400,
            toolbar: { show: false }
        },
        colors: ['#0496ff'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 }
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        }
    };
    if (document.querySelector("#salesChart")) {
        new ApexCharts(document.querySelector("#salesChart"), options).render();
    }
</script>
@endpush

