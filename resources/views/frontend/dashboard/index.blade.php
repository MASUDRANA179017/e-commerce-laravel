@extends('layouts.frontend')

@section('title', 'My Dashboard')

@section('content')
<div class="breadcrumb-area bg-gray-4 py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="my-account-area pt-80 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="my-account-tab-menu nav" role="tablist">
                    <a href="{{ route('dashboard') }}" class="active"><i class="bx bxs-dashboard"></i> Dashboard</a>
                    <a href="{{ route('profile.edit') }}"><i class="bx bx-user"></i> Account Details</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="bx bx-log-out"></i> Logout</a>
                    </form>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tab-content" id="my-account-tab-content">
                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                        <div class="myaccount-content">
                            <h3>Dashboard</h3>
                            <div class="welcome">
                                <p>Hello, <strong>{{ Auth::user()->name }}</strong> (If Not <strong>{{ Auth::user()->name }} !</strong> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout">Logout</a>)</p>
                            </div>
                            <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h4>Recent Orders</h4>
                                    @if($recentOrders->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentOrders as $order)
                                                <tr>
                                                    <td>#{{ $order->order_number ?? $order->id }}</td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>{{ ucfirst($order->status) }}</td>
                                                    <td>{{ number_format($order->total, 2) }}</td>
                                                    <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <p>No recent orders found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
    .my-account-tab-menu a {
        border: 1px solid #ddd;
        border-bottom: none;
        color: #333;
        display: block;
        font-size: 16px;
        font-weight: 500;
        padding: 15px 20px;
        text-transform: capitalize;
    }
    .my-account-tab-menu a:last-child {
        border-bottom: 1px solid #ddd;
    }
    .my-account-tab-menu a:hover, .my-account-tab-menu a.active {
        background-color: #007bff;
        color: #fff;
    }
    .myaccount-content {
        border: 1px solid #eeeeee;
        padding: 30px;
    }
</style>
@endsection
