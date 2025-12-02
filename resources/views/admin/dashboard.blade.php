@extends('layouts.master')

@section('title', 'Dashboard')

@push('styles')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #7367f0 0%, #4A2A85 100%);
        border-radius: 15px;
        padding: 30px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .welcome-card::before {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        right: 30px;
        bottom: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .stat-card-modern {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        height: 100%;
    }
    .stat-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .trend-badge {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 20px;
        font-weight: 600;
    }
    .trend-up { background: rgba(140, 192, 82, 0.15); color: #8CC052; }
    .trend-down { background: rgba(235, 84, 99, 0.15); color: #EB5463; }
    .chart-card {
        background: #fff;
        border-radius: 15px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 15px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        color: #374151;
        transition: all 0.3s ease;
    }
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-color: var(--qbit-primary);
        color: var(--qbit-primary);
    }
    .quick-action-btn i {
        font-size: 28px;
        margin-bottom: 8px;
        color: var(--qbit-primary);
    }
    .progress-thin {
        height: 6px;
        border-radius: 3px;
    }
    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-2">Welcome back, {{ auth()->user()->name ?? 'Admin' }}! 👋</h3>
                    <p class="mb-0 opacity-75">Here's what's happening with your store today.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <span class="opacity-75"><i class="bx bx-calendar me-1"></i> {{ now()->format('l, F d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Row -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="stat-card-modern">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon-box" style="background: rgba(65, 150, 250, 0.15);">
                    <i class="bx bx-wallet" style="color: #4196FA;"></i>
                </div>
                <span class="trend-badge trend-up"><i class="bx bx-up-arrow-alt"></i> {{ $revenueGrowth ?? 0 }}%</span>
            </div>
            <h3 class="fw-bold mb-1">৳{{ number_format($stats['total_revenue'] ?? 0, 0) }}</h3>
            <p class="text-muted mb-0 fs-13">Total Revenue</p>
            <div class="mt-2">
                <small class="text-muted">Today: <span class="fw-bold text-dark">৳{{ number_format($todayStats['revenue'] ?? 0, 0) }}</span></small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="stat-card-modern">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon-box" style="background: rgba(140, 192, 82, 0.15);">
                    <i class="bx bx-cart" style="color: #8CC052;"></i>
                </div>
                <span class="qbit-badge-success">{{ $todayStats['orders'] ?? 0 }} today</span>
            </div>
            <h3 class="fw-bold mb-1">{{ number_format($stats['total_orders'] ?? 0) }}</h3>
            <p class="text-muted mb-0 fs-13">Total Orders</p>
            <div class="mt-2">
                <small class="text-muted">This month: <span class="fw-bold text-dark">{{ $monthStats['orders'] ?? 0 }}</span></small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="stat-card-modern">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon-box" style="background: rgba(115, 103, 240, 0.15);">
                    <i class="bx bx-package" style="color: #7367F0;"></i>
                </div>
                <a href="{{ route('admin.product.all') }}" class="qbit-badge-purple">View All</a>
            </div>
            <h3 class="fw-bold mb-1">{{ number_format($stats['total_products'] ?? 0) }}</h3>
            <p class="text-muted mb-0 fs-13">Total Products</p>
            <div class="mt-2">
                <small class="text-muted">Categories: <span class="fw-bold text-dark">{{ $stats['total_categories'] ?? 0 }}</span></small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="stat-card-modern">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon-box" style="background: rgba(247, 137, 30, 0.15);">
                    <i class="bx bx-user" style="color: #F7891E;"></i>
                </div>
                <span class="qbit-badge-orange">+{{ $todayStats['new_customers'] ?? 0 }} new</span>
            </div>
            <h3 class="fw-bold mb-1">{{ number_format($stats['total_users'] ?? 0) }}</h3>
            <p class="text-muted mb-0 fs-13">Total Customers</p>
            <div class="mt-2">
                <small class="text-muted">Brands: <span class="fw-bold text-dark">{{ $stats['total_brands'] ?? 0 }}</span></small>
            </div>
        </div>
    </div>

    <!-- Order Status Mini Cards -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-1">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none"><circle cx="60" cy="50" r="40" fill="rgba(251, 110, 82, 0.15)"/></svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-time-five fs-20" style="color: #FB6E52;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['pending_orders'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Pending Orders</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-2">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none"><circle cx="60" cy="50" r="40" fill="rgba(27, 132, 255, 0.15)"/></svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-loader-circle fs-20" style="color: #1B84FF;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['processing_orders'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Processing</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner counter-bg-3">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none"><circle cx="60" cy="50" r="40" fill="rgba(140, 192, 82, 0.15)"/></svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon">
                    <i class="bx bx-check-circle fs-20" style="color: #8CC052;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['completed_orders'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Completed</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="custom-counter-inner" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%); border: 1px solid rgba(235, 84, 99, 0.2);">
            <svg class="bottom-svg" viewBox="0 0 80 60" fill="none"><circle cx="60" cy="50" r="40" fill="rgba(235, 84, 99, 0.15)"/></svg>
            <div class="d-flex align-items-center gap-3">
                <div class="custom-counter-icon" style="background: rgba(235, 84, 99, 0.15);">
                    <i class="bx bx-x-circle fs-20" style="color: #EB5463;"></i>
                </div>
                <div>
                    <h3 class="fw-700 fs-24 mb-0">{{ $stats['cancelled_orders'] ?? 0 }}</h3>
                    <p class="mb-0 fs-13 text-muted">Cancelled</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Overview Chart -->
    <div class="col-xxl-8 mb-4">
        <div class="chart-card h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between p-3">
                <div>
                    <h5 class="mb-1 fw-bold qb-card-header-title-14-600">Sales Overview</h5>
                    <small class="text-muted">Monthly revenue and orders comparison</small>
                </div>
                <div class="d-flex gap-2">
                    <button class="select-btn-white btn-sm active" data-chart="monthly">Monthly</button>
                    <button class="select-btn-white btn-sm" data-chart="weekly">Weekly</button>
                </div>
            </div>
            <div class="card-body">
                <div id="salesChart" style="height: 320px;"></div>
            </div>
        </div>
    </div>

    <!-- Order Distribution Pie Chart -->
    <div class="col-xxl-4 mb-4">
        <div class="chart-card h-100">
            <div class="card-header bg-white p-3">
                <h5 class="mb-1 fw-bold qb-card-header-title-14-600">Order Distribution</h5>
                <small class="text-muted">By status</small>
            </div>
            <div class="card-body">
                <div id="orderPieChart" style="height: 280px;"></div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12 mb-4">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600"><i class="bx bx-zap me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.product-create.index') }}" class="quick-action-btn w-100">
                            <i class="bx bx-plus-circle"></i>
                            <span class="fs-13 fw-medium">Add Product</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.orders.index') }}" class="quick-action-btn w-100">
                            <i class="bx bx-cart"></i>
                            <span class="fs-13 fw-medium">View Orders</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.customers.index') }}" class="quick-action-btn w-100">
                            <i class="bx bx-user"></i>
                            <span class="fs-13 fw-medium">Customers</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.product.category.index') }}" class="quick-action-btn w-100">
                            <i class="bx bx-category"></i>
                            <span class="fs-13 fw-medium">Categories</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.inventory.stock') }}" class="quick-action-btn w-100">
                            <i class="bx bx-box"></i>
                            <span class="fs-13 fw-medium">Inventory</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.reports.sales') }}" class="quick-action-btn w-100">
                            <i class="bx bx-bar-chart-alt-2"></i>
                            <span class="fs-13 fw-medium">Reports</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-xxl-8 mb-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600"><i class="bx bx-receipt me-2"></i>Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="qbit-badge-primary">View All <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Order</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td class="ps-3">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-primary text-decoration-none">
                                        #{{ $order->order_number }}
                                    </a>
                                    <br><small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="customer-avatar" style="background: linear-gradient(135deg, var(--qbit-primary) 0%, var(--qbit-purple) 100%);">
                                            {{ strtoupper(substr($order->first_name ?? 'C', 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-medium d-block">{{ $order->full_name }}</span>
                                            <small class="text-muted">{{ $order->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="qbit-badge-info"><i class="bx bx-package"></i> {{ $order->items->count() }}</span></td>
                                <td><span class="fw-bold">৳{{ number_format($order->total, 2) }}</span></td>
                                <td>
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'gray'
                                        };
                                    @endphp
                                    <span class="qbit-badge-{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn-info" title="View"><i class="bx bx-show"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bx bx-cart bx-lg text-muted d-block mb-2"></i>
                                    <span class="text-muted">No orders yet</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Low Stock -->
    <div class="col-xxl-4 mb-4">
        <div class="row">
            <!-- Recent Activity -->
            <div class="col-12 mb-4">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold qb-card-header-title-14-600"><i class="bx bx-time me-2"></i>Recent Activity</h5>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        @forelse($recentActivities ?? [] as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="background: rgba(var(--qbit-{{ $activity['color'] }}-rgb), 0.15);">
                                <i class="bx {{ $activity['icon'] }}" style="color: var(--qbit-{{ $activity['color'] }});"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-medium fs-13">{{ $activity['title'] }}</p>
                                <small class="text-muted">{{ $activity['description'] }}</small>
                                <br><small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bx bx-time bx-lg d-block mb-2"></i>
                            <span>No recent activity</span>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold qb-card-header-title-14-600"><i class="bx bx-error me-2 text-danger"></i>Low Stock</h5>
                        <span class="qbit-badge-danger"><i class="bx bx-error"></i> {{ count($lowStockProducts ?? []) }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @forelse($lowStockProducts ?? [] as $product)
                                    <tr>
                                        <td class="py-3 ps-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="wh-40 rounded bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bx bx-package text-muted"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-medium fs-13 d-block">{{ Str::limit($product->title ?? $product->name, 20) }}</span>
                                                    <small class="text-danger"><i class="bx bx-error-circle"></i> {{ $product->stock_quantity ?? 0 }} left</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 pe-3 text-end">
                                            <a href="{{ route('admin.inventory.stock') }}" class="action-btn-orange" title="Restock"><i class="bx bx-plus"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4">
                                            <i class="bx bx-check-circle text-success fs-2 d-block mb-2"></i>
                                            <span class="text-success">All products well stocked!</span>
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
    </div>

    <!-- Top Products & Top Categories -->
    <div class="col-xxl-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold qb-card-header-title-14-600"><i class="bx bx-trending-up me-2"></i>Top Selling Products</h5>
                <a href="{{ route('admin.product.all') }}" class="qbit-badge-purple">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($topProducts ?? [] as $index => $product)
                            <tr>
                                <td class="py-3 ps-3" style="width: 40px;">
                                    <span class="qbit-badge-{{ $index == 0 ? 'success' : ($index == 1 ? 'primary' : ($index == 2 ? 'info' : 'gray')) }}">
                                        #{{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="wh-45 rounded bg-light d-flex align-items-center justify-content-center overflow-hidden">
                                            @php
                                                $coverImg = \DB::table('product_images')->where('product_id', $product->id)->where('is_cover', true)->first();
                                            @endphp
                                            @if($coverImg)
                                                <img src="{{ asset('storage/' . $coverImg->path) }}" class="w-100 h-100 object-fit-cover" alt="">
                                            @else
                                                <i class="bx bx-package text-muted"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="fw-medium d-block">{{ Str::limit($product->title ?? $product->name, 25) }}</span>
                                            <small class="text-muted">৳{{ number_format($product->price ?? 0, 2) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-end pe-3">
                                    @if(isset($product->total_sold))
                                        <span class="fw-bold text-success">{{ $product->total_sold }} sold</span>
                                    @else
                                        <span class="qbit-badge-success"><i class="bx bx-package"></i> In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No products found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Sales Chart -->
    <div class="col-xxl-6 mb-4">
        <div class="chart-card h-100">
            <div class="card-header bg-white p-3">
                <h5 class="mb-1 fw-bold qb-card-header-title-14-600"><i class="bx bx-line-chart me-2"></i>Weekly Sales</h5>
                <small class="text-muted">Last 7 days performance</small>
            </div>
            <div class="card-body">
                <div id="weeklyChart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Sales Data
    const monthlySales = @json($monthlySales ?? [0,0,0,0,0,0,0,0,0,0,0,0]);
    const monthlyOrders = @json($monthlyOrders ?? [0,0,0,0,0,0,0,0,0,0,0,0]);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    // Daily Sales Data
    const dailySales = @json($dailySales ?? [0,0,0,0,0,0,0]);
    const dailyLabels = @json($dailyLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']);

    // Order Distribution Data
    const ordersByStatus = @json($ordersByStatus ?? ['pending' => 0, 'processing' => 0, 'shipped' => 0, 'delivered' => 0, 'cancelled' => 0]);

    // Main Sales Chart
    var salesOptions = {
        series: [{
            name: 'Revenue',
            type: 'area',
            data: monthlySales
        }, {
            name: 'Orders',
            type: 'line',
            data: monthlyOrders
        }],
        chart: {
            height: 320,
            type: 'line',
            toolbar: { show: false },
            fontFamily: 'Montserrat, sans-serif'
        },
        colors: ['#7367F0', '#8CC052'],
        stroke: {
            width: [0, 3],
            curve: 'smooth'
        },
        fill: {
            type: ['gradient', 'solid'],
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.5,
                opacityTo: 0.1,
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: months,
            labels: { style: { colors: '#6b7280', fontSize: '12px' } }
        },
        yaxis: [{
            title: { text: 'Revenue (৳)', style: { color: '#6b7280' } },
            labels: {
                style: { colors: '#6b7280' },
                formatter: (val) => '৳' + val.toLocaleString()
            }
        }, {
            opposite: true,
            title: { text: 'Orders', style: { color: '#6b7280' } },
            labels: { style: { colors: '#6b7280' } }
        }],
        legend: { position: 'top', horizontalAlign: 'right' },
        tooltip: {
            y: {
                formatter: function(val, { seriesIndex }) {
                    return seriesIndex === 0 ? '৳' + val.toLocaleString() : val + ' orders';
                }
            }
        },
        grid: { borderColor: '#f1f1f1' }
    };

    if (document.querySelector("#salesChart")) {
        new ApexCharts(document.querySelector("#salesChart"), salesOptions).render();
    }

    // Order Pie Chart
    var pieOptions = {
        series: [ordersByStatus.pending, ordersByStatus.processing, ordersByStatus.shipped, ordersByStatus.delivered, ordersByStatus.cancelled],
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Montserrat, sans-serif'
        },
        labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
        colors: ['#FB6E52', '#1B84FF', '#4196FA', '#8CC052', '#EB5463'],
        legend: {
            position: 'bottom',
            fontSize: '12px'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#374151'
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false }
    };

    if (document.querySelector("#orderPieChart")) {
        new ApexCharts(document.querySelector("#orderPieChart"), pieOptions).render();
    }

    // Weekly Sales Bar Chart
    var weeklyOptions = {
        series: [{
            name: 'Sales',
            data: dailySales
        }],
        chart: {
            type: 'bar',
            height: 280,
            toolbar: { show: false },
            fontFamily: 'Montserrat, sans-serif'
        },
        colors: ['#7367F0'],
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '50%',
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: dailyLabels,
            labels: { style: { colors: '#6b7280', fontSize: '12px' } }
        },
        yaxis: {
            labels: {
                style: { colors: '#6b7280' },
                formatter: (val) => '৳' + val.toLocaleString()
            }
        },
        grid: { borderColor: '#f1f1f1' },
        tooltip: {
            y: {
                formatter: (val) => '৳' + val.toLocaleString()
            }
        }
    };

    if (document.querySelector("#weeklyChart")) {
        new ApexCharts(document.querySelector("#weeklyChart"), weeklyOptions).render();
    }
});
</script>
@endpush
