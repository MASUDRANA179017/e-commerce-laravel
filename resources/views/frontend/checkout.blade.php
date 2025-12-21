@extends('layouts.frontend')

@section('title', 'Checkout - GrowUp E-Commerce')

@section('content')
<!-- Banner Section -->
<section class="common-banner" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="common-banner__content text-center">
                <span class="sub-title"><i class="fa-solid fa-credit-card"></i> Complete Your Order</span>
                <h2 class="title-animation" style="font-size: 36px;">Checkout</h2>
                <nav aria-label="breadcrumb" class="mt-3">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-white-50">Cart</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Checkout Section -->
<section class="checkout-section py-5">
    <div class="container">
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row">
                <!-- Billing Details -->
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="billing-details bg-white rounded-4 shadow-sm p-4" data-aos="fade-up">
                        <h5 class="mb-4 pb-3 border-bottom">
                            <i class="fa-solid fa-truck me-2"></i>Delivery Information
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            @guest
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Create a password">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            @endguest
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $lastOrder->phone ?? $user->phone ?? '') }}" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Street Address <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="House number and street name" value="{{ old('address', $lastOrder->address ?? $user->address ?? '') }}" required>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" name="address2" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('address2', $lastOrder->address2 ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $lastOrder->city ?? '') }}" required>
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State/Region</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', $lastOrder->state ?? '') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                                <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" value="{{ old('zip_code', $lastOrder->zip_code ?? '') }}" required>
                                @error('zip_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Order Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Special instructions for delivery...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="payment-method bg-white rounded-4 shadow-sm p-4 mt-4" data-aos="fade-up" data-aos-delay="100">
                        <h5 class="mb-4 pb-3 border-bottom">
                            <i class="fa-solid fa-wallet me-2"></i>Payment Method
                        </h5>
                        
                        <div class="payment-options">
                            <div class="form-check payment-option p-3 mb-3 border rounded-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label d-flex align-items-center w-100" for="cod">
                                    <i class="fa-solid fa-money-bill-wave fa-2x text-success me-3"></i>
                                    <div>
                                        <p>Cash on Delivery</p>
                                        <small class="d-block text-muted">Pay when you receive your order</small>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-check payment-option p-3 mb-3 border rounded-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank_transfer">
                                <label class="form-check-label d-flex align-items-center w-100" for="bank">
                                    <i class="fa-solid fa-building-columns fa-2x text-primary me-3"></i>
                                    <div>
                                        <p>Bank Transfer</p>
                                        <small class="d-block text-muted">Direct bank transfer to our account</small>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-check payment-option p-3 mb-3 border rounded-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                                <label class="form-check-label d-flex align-items-center w-100" for="card">
                                    <i class="fa-solid fa-credit-card fa-2x text-info me-3"></i>
                                    <div>
                                        <p>Credit/Debit Card</p>
                                        <small class="d-block text-muted">Visa, Mastercard, American Express</small>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-check payment-option p-3 border rounded-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="bkash" value="bkash">
                                <label class="form-check-label d-flex align-items-center w-100" for="bkash">
                                    <i class="fa-solid fa-mobile-screen fa-2x text-danger me-3"></i>
                                    <div>
                                        <p>Mobile Banking</p>
                                        <small class="d-block text-muted">bKash, Nagad, Rocket</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="order-summary bg-white rounded-4 shadow-sm p-4 position-sticky" style="top: 100px;" data-aos="fade-up" data-aos-delay="200">
                        <h5 class="mb-4 pb-3 border-bottom">
                            <i class="fa-solid fa-receipt me-2"></i>Order Summary
                        </h5>
                        
                        <!-- Order Items -->
                        <div class="order-items mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($cartItems ?? [] as $item)
                            <div class="order-item d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="item-image position-relative me-3" style="width: 60px; height: 60px;">
                                    <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}" alt="{{ $item->name }}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/60?text=No+Image'">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">{{ $item->qty }}</span>
                                </div>
                                <div class="item-details flex-grow-1">
                                    <h6 class="mb-0" style="font-size: 14px;">{{ Str::limit($item->name, 25) }}</h6>
                                    @if($item->options->variant ?? false)
                                    <small class="text-muted">{{ $item->options->variant }}</small>
                                    @endif
                                </div>
                                <div class="item-price">
                                    <span class="fw-bold">৳{{ number_format($item->price * $item->qty, 2) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted" style="font-size: 16px;">Subtotal</span>
                                <span style="font-size: 16px; font-weight: 600;">৳{{ number_format($subtotal ?? 0, 2) }}</span>
                            </div>
                            @if(($discount ?? 0) > 0)
                            <div class="d-flex justify-content-between mb-3 text-success">
                                <span style="font-size: 16px;">Discount</span>
                                <span style="font-size: 16px; font-weight: 600;">-৳{{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted" style="font-size: 16px;">Shipping</span>
                                <span style="font-size: 16px; font-weight: 600;">{{ ($shipping ?? 0) > 0 ? '৳' . number_format($shipping, 2) : 'Free' }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4 pt-2">
                                <span style="font-size: 20px; font-weight: 700; color: #1a1a2e;">Total</span>
                                <span style="font-size: 24px; font-weight: 700; color: #0496ff;">৳{{ number_format($total ?? 0, 2) }}</span>
                            </div>
                        </div>
                        
                        <!-- Terms Agreement -->
                        <div class="mb-4">
                            <label class="d-flex align-items-start gap-3 cursor-pointer" style="cursor: pointer;">
                                <input type="checkbox" id="terms" name="terms" required 
                                       style="width: 20px; height: 20px; min-width: 20px; margin-top: 2px; accent-color: #0496ff; cursor: pointer;"
                                       class="@error('terms') is-invalid @enderror">
                                <span class="text-muted" style="line-height: 1.5;">
                                    I have read and agree to the <a href="#" target="_blank" class="text-primary">Terms & Conditions</a> and <a href="#" target="_blank" class="text-primary">Privacy Policy</a>
                                </span>
                            </label>
                            @error('terms')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <!-- Place Order Button -->
                        <button type="submit" class="btn btn-primary w-100 py-3 mb-3" id="place-order-btn">
                            <i class="fa-solid fa-lock me-2"></i>Place Order
                        </button>
                        
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fa-solid fa-shield-halved me-1"></i>Your payment information is secure
                            </small>
                        </div>
                        
                        <!-- Back to Cart -->
                        <div class="text-center mt-3">
                            <a href="{{ route('cart.index') }}" class="text-muted">
                                <i class="fa-solid fa-arrow-left me-1"></i>Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<style>
    .payment-option {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .payment-option:hover {
        border-color: #0496ff !important;
        background-color: rgba(4, 150, 255, 0.05);
    }
    .payment-option .form-check-input:checked + .form-check-label {
        color: #0496ff;
    }
    .payment-option:has(.form-check-input:checked) {
        border-color: #0496ff !important;
        background-color: rgba(4, 150, 255, 0.05);
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        var btn = document.getElementById('place-order-btn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    });
</script>
@endpush

