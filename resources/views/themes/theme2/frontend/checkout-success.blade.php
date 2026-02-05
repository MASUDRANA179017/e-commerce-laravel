@extends('layouts.frontend')

@section('title', 'Order Confirmed - GrowUp E-Commerce')

@section('content')
<section class="checkout-success py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card bg-white rounded-4 shadow-sm p-5 text-center" data-aos="fade-up">
                    <!-- Success Icon -->
                    <div class="success-icon mb-4">
                        <div class="icon-circle mx-auto" style="width: 120px; height: 120px; background: rgba(10, 185, 100, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-check fa-4x" style="color: #0ab964;"></i>
                        </div>
                    </div>
                    
                    <!-- Success Message -->
                    <h2 class="mb-3" style="color: #0ab964;">Order Confirmed!</h2>
                    <p class="lead text-muted mb-4">Thank you for your purchase. Your order has been received and is being processed.</p>
                    
                    <!-- Order Details -->
                    <div class="order-details bg-light rounded-3 p-4 mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="text-muted mb-1">Order Number</p>
                                <h5 class="mb-0 text-primary">{{ $orderNumber ?? 'N/A' }}</h5>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="text-muted mb-1">Date</p>
                                <h5 class="mb-0">{{ now()->format('M d, Y') }}</h5>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted mb-1">Total Amount</p>
                                <h5 class="mb-0 text-success">৳{{ number_format($order->total ?? $sessionOrder['total'] ?? 0, 2) }}</h5>
                            </div>
                        </div>
                    </div>

                    @if(isset($order) && $order->items && $order->items->count() > 0)
                    <!-- Order Items -->
                    <div class="order-items text-start bg-light rounded-3 p-4 mb-4">
                        <h5 class="mb-3"><i class="fa-solid fa-shopping-bag me-2 text-primary"></i>Order Items</h5>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                            @if($item->variant_name)
                                            <br><small class="text-muted">{{ $item->variant_name }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">৳{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <td colspan="2" class="text-end"><strong>Subtotal:</strong></td>
                                        <td class="text-end">৳{{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    @if($order->discount > 0)
                                    <tr class="text-success">
                                        <td colspan="2" class="text-end">Discount:</td>
                                        <td class="text-end">-৳{{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2" class="text-end">Shipping:</td>
                                        <td class="text-end">{{ $order->shipping > 0 ? '৳' . number_format($order->shipping, 2) : 'Free' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                        <td class="text-end"><strong class="text-primary">৳{{ number_format($order->total, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Delivery Info -->
                    <div class="delivery-info text-start bg-light rounded-3 p-4 mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6 class="mb-2"><i class="fa-solid fa-truck me-2 text-primary"></i>Delivery Address</h6>
                                <p class="mb-0">
                                    {{ $order->first_name }} {{ $order->last_name }}<br>
                                    {{ $order->address }}<br>
                                    @if($order->address2){{ $order->address2 }}<br>@endif
                                    {{ $order->city }}, {{ $order->zip_code }}<br>
                                    <i class="fa-solid fa-phone me-1"></i>{{ $order->phone }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2"><i class="fa-solid fa-wallet me-2 text-primary"></i>Payment Method</h6>
                                <p class="mb-0">
                                    @switch($order->payment_method)
                                        @case('cod')
                                            <i class="fa-solid fa-money-bill-wave text-success me-1"></i>Cash on Delivery
                                            @break
                                        @case('bank_transfer')
                                            <i class="fa-solid fa-building-columns text-primary me-1"></i>Bank Transfer
                                            @break
                                        @case('card')
                                            <i class="fa-solid fa-credit-card text-info me-1"></i>Credit/Debit Card
                                            @break
                                        @case('bkash')
                                            <i class="fa-solid fa-mobile-screen text-danger me-1"></i>bKash
                                            @break
                                        @default
                                            {{ ucfirst($order->payment_method) }}
                                    @endswitch
                                </p>
                                <p class="mb-0 mt-2">
                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- What's Next -->
                    <div class="whats-next text-start bg-light rounded-3 p-4 mb-4">
                        <h5 class="mb-3"><i class="fa-solid fa-info-circle me-2 text-primary"></i>What's Next?</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                You will receive an order confirmation email shortly.
                            </li>
                            <li class="mb-2">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                We will notify you when your order is shipped.
                            </li>
                            <li class="mb-2">
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Track your order status in your account dashboard.
                            </li>
                            <li>
                                <i class="fa-solid fa-check text-success me-2"></i>
                                Expected delivery: 3-7 business days.
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons d-flex flex-wrap gap-3 justify-content-center">
                        @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fa-solid fa-user me-2"></i>My Account
                        </a>
                        @endauth
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fa-solid fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                    </div>
                    
                    <!-- Contact Support -->
                    <div class="contact-support mt-5 pt-4 border-top">
                        <p class="text-muted mb-0">
                            <i class="fa-solid fa-question-circle me-1"></i>
                            Have questions? <a href="{{ route('frontend.contact') }}">Contact our support team</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
