@extends('layouts.master')

@section('title', 'Customer Analytics')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Customer Analytics</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.reports.export', ['type' => 'customers'] + request()->query()) }}" class="select-btn-info text-decoration-none">
                    <span class="material-symbols-outlined fs-14">download</span> Export
                </a>
            </div>
        </div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Customer Analytics</li>
            </ol>
        </nav>
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
                        <h4 class="mb-0 fw-bold">{{ $totalCustomers }}</h4>
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
                        <h4 class="mb-0 fw-bold">{{ $newCustomers }}</h4>
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
                        <span class="material-symbols-outlined text-info">repeat</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $returningCustomers }}</h4>
                        <span class="text-muted">Returning Customers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Growth Chart -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Customer Growth</h5>
            </div>
            <div class="card-body">
                <div id="customerChart" style="height: 350px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var options = {
        series: [{
            name: 'New Customers',
            data: @json($customerCounts)
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        colors: ['#0496ff'],
        plotOptions: {
            bar: { borderRadius: 4, columnWidth: '60%' }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: @json($months)
        }
    };
    if (document.querySelector("#customerChart")) {
        new ApexCharts(document.querySelector("#customerChart"), options).render();
    }
</script>
@endpush

