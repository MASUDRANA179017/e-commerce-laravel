@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Page Header -->
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Dashboard</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card bg-primary bg-opacity-10 border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block mb-1 text-muted">Total Products</span>
                        <h4 class="mb-0 fw-bold text-primary">{{ number_format($stats['total_products'] ?? 0) }}</h4>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined fs-1 text-primary opacity-50">inventory_2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card bg-success bg-opacity-10 border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block mb-1 text-muted">Total Orders</span>
                        <h4 class="mb-0 fw-bold text-success">{{ number_format($stats['total_orders'] ?? 0) }}</h4>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined fs-1 text-success opacity-50">shopping_cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card bg-warning bg-opacity-10 border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block mb-1 text-muted">Total Users</span>
                        <h4 class="mb-0 fw-bold text-warning">{{ number_format($stats['total_users'] ?? 0) }}</h4>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined fs-1 text-warning opacity-50">group</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-xl-4 col-sm-6">
        <div class="card bg-info bg-opacity-10 border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block mb-1 text-muted">Total Revenue</span>
                        <h4 class="mb-0 fw-bold text-info">৳{{ number_format($stats['total_revenue'] ?? 0, 2) }}</h4>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined fs-1 text-info opacity-50">payments</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Cards -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="wh-50 rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-warning">pending</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $stats['pending_orders'] ?? 0 }}</h5>
                        <span class="text-muted fs-13">Pending Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-sm-6">
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="wh-50 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-primary">sync</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $stats['processing_orders'] ?? 0 }}</h5>
                        <span class="text-muted fs-13">Processing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-sm-6">
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="wh-50 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-success">check_circle</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $stats['completed_orders'] ?? 0 }}</h5>
                        <span class="text-muted fs-13">Completed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-sm-6">
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="wh-50 rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-danger">cancel</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $stats['cancelled_orders'] ?? 0 }}</h5>
                        <span class="text-muted fs-13">Cancelled</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="col-xxl-8">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Sales Overview</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        This Year
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">This Week</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="salesChart" style="height: 350px;"></div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-xxl-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Top Products</h5>
                <a href="{{ route('admin.product.all') }}" class="text-primary text-decoration-none fs-13">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($topProducts ?? [] as $product)
                            <tr>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="wh-45 rounded overflow-hidden bg-light">
                                            @if($product->coverImage)
                                                <img src="{{ asset('storage/' . $product->coverImage->image) }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <span class="material-symbols-outlined text-muted">image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-medium">{{ Str::limit($product->name, 25) }}</h6>
                                            <small class="text-muted">৳{{ number_format($product->price, 2) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-end">
                                    <span class="badge bg-success bg-opacity-10 text-success">In Stock: {{ $product->stock }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4">
                                    <span class="text-muted">No products found</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-xxl-8">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="text-primary text-decoration-none fs-13">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td class="ps-3">#{{ $order->id }}</td>
                                <td>{{ $order->customer_name ?? 'N/A' }}</td>
                                <td>৳{{ number_format($order->total ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color ?? 'secondary' }} bg-opacity-10 text-{{ $order->status_color ?? 'secondary' }}">
                                        {{ $order->status ?? 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') ?? '-' }}</td>
                                <td class="text-end pe-3">
                                    <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <span class="text-muted">No orders found</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-xxl-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Low Stock Alert</h5>
                <span class="badge bg-danger">{{ count($lowStockProducts ?? []) }} items</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($lowStockProducts ?? [] as $product)
                            <tr>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="wh-40 rounded overflow-hidden bg-light">
                                            @if($product->coverImage)
                                                <img src="{{ asset('storage/' . $product->coverImage->image) }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <span class="material-symbols-outlined text-muted fs-14">image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-medium fs-13">{{ Str::limit($product->name, 20) }}</h6>
                                            <small class="text-danger">Only {{ $product->stock }} left</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-end">
                                    <a href="#" class="btn btn-sm btn-warning">Restock</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4">
                                    <span class="text-success"><i class="material-symbols-outlined align-middle">check_circle</i> All products are well stocked</span>
                                </td>
                            </tr>
                            @endforelse
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
    // Sales Chart
    var salesOptions = {
        series: [{
            name: 'Sales',
            data: [30, 40, 35, 50, 49, 60, 70, 91, 125, 80, 95, 110]
        }, {
            name: 'Orders',
            data: [20, 35, 25, 40, 39, 50, 60, 81, 100, 70, 85, 95]
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: false
            }
        },
        colors: ['#0496ff', '#28a745'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
            }
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            }
        },
        legend: {
            position: 'top'
        }
    };
    
    if (document.querySelector("#salesChart")) {
        var salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
        salesChart.render();
    }
</script>
@endpush

