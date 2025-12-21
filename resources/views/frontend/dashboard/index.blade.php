@extends('layouts.user-master')

@section('title', 'My Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h3 class="mb-0">My Dashboard</h3>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb align-items-center mb-0 lh-1">
            <li class="breadcrumb-item">
                <a href="#" class="d-flex align-items-center text-decoration-none">
                    <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                    <span class="text-secondary fw-medium hover">Dashboard</span>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <span class="fw-medium">Overview</span>
            </li>
        </ol>
    </nav>
</div>

<div class="row">
    <!-- Account Information Card -->
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card bg-white border-0 rounded-10 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                    <h4 class="fw-semibold fs-18 mb-0">Account Information</h4>
                    <a href="{{ route('user.account-details') }}" class="btn btn-primary text-white py-2 px-3">
                        Edit Details
                    </a>
                </div>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-shrink-0">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/andrew-rashel.png') }}" 
                             class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="user-image">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="fs-18 fw-semibold mb-1">{{ Auth::user()->name }}</h4>
                        <span class="fs-14 text-secondary">{{ Auth::user()->email }}</span>
                    </div>
                </div>

                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center mb-3">
                        <i class="ri-phone-line fs-20 text-primary me-2"></i>
                        <span class="text-secondary">{{ Auth::user()->phone ?? 'N/A' }}</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ri-map-pin-line fs-20 text-primary me-2"></i>
                        <span class="text-secondary">{{ Auth::user()->address ?? 'N/A' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Orders Summary (Optional, can be removed if strictly only basic info is wanted, but usually useful) -->
    <div class="col-xl-8 col-lg-6 col-md-6">
        <div class="card bg-white border-0 rounded-10 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                    <h4 class="fw-semibold fs-18 mb-0">Recent Activity</h4>
                </div>
                <div class="alert alert-info border-0 text-dark">
                    Welcome back, <strong>{{ Auth::user()->name }}</strong>! <br>
                    From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.
                </div>
                
                @if($recentOrders->count() > 0)
                <h5 class="fs-16 fw-semibold mb-3">Recent Orders</h5>
                <div class="default-table-area style-two">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number ?? $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_color }} bg-opacity-10 text-{{ $order->status_color }} p-2 fs-12 fw-normal">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($order->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <p class="text-secondary">No recent orders found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
