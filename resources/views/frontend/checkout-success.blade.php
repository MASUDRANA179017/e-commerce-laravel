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
                            <div class="col-md-6 mb-3 mb-md-0">
                                <p class="text-muted mb-1">Order Number</p>
                                <h4 class="mb-0">{{ $orderNumber ?? 'N/A' }}</h4>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Date</p>
                                <h4 class="mb-0">{{ now()->format('M d, Y') }}</h4>
                            </div>
                        </div>
                    </div>
                    
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

