@extends('themes.theme2.layouts.frontend')

@section('title', 'Checkout - GrowUp E-Commerce')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="mb-4 text-center">
            <h2 class="fw-bold" style="font-size: 32px;">Checkout</h2>
            <p class="text-muted mb-0">Complete your order in a few simple steps</p>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 px-4 py-3">
                            <h5 class="mb-0"><i class="fa-solid fa-truck me-2"></i>Delivery Information</h5>
                        </div>
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', optional($lastOrder)->first_name ?? auth()->user()->first_name ?? '') }}" required>
                                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', optional($lastOrder)->last_name ?? auth()->user()->last_name ?? '') }}" required>
                                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', optional($lastOrder)->email ?? auth()->user()->email ?? '') }}" required>
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
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', optional($lastOrder)->phone ?? auth()->user()->phone ?? '') }}" required>
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Street Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="House number and street name" value="{{ old('address', optional($lastOrder)->address ?? auth()->user()->address ?? '') }}" required>
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="text" name="address2" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('address2', optional($lastOrder)->address2 ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" id="cityInput" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', optional($lastOrder)->city ?? '') }}" required>
                                    @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">State/Region</label>
                                    <input type="text" name="state" class="form-control" value="{{ old('state', optional($lastOrder)->state ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                                    <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" value="{{ old('zip_code', optional($lastOrder)->zip_code ?? '') }}" required>
                                    @error('zip_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Order Notes (optional)</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Special instructions for delivery...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 px-4 py-3">
                            <h5 class="mb-0"><i class="fa-solid fa-wallet me-2"></i>Payment Method</h5>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label d-flex align-items-center" for="cod">
                                    <i class="fa-solid fa-money-bill-wave fa-2x text-success me-3"></i>
                                    <div>
                                        <p class="mb-0">Cash on Delivery</p>
                                        <small class="text-muted">Pay when you receive your order</small>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank_transfer">
                                <label class="form-check-label d-flex align-items-center" for="bank">
                                    <i class="fa-solid fa-building-columns fa-2x text-primary me-3"></i>
                                    <div>
                                        <p class="mb-0">Bank Transfer</p>
                                        <small class="text-muted">Direct bank transfer to our account</small>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                                <label class="form-check-label d-flex align-items-center" for="card">
                                    <i class="fa-solid fa-credit-card fa-2x text-info me-3"></i>
                                    <div>
                                        <p class="mb-0">Credit/Debit Card</p>
                                        <small class="text-muted">Visa, Mastercard, American Express</small>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="bkash" value="bkash">
                                <label class="form-check-label d-flex align-items-center" for="bkash">
                                    <i class="fa-solid fa-mobile-screen fa-2x text-danger me-3"></i>
                                    <div>
                                        <p class="mb-0">Mobile Banking</p>
                                        <small class="text-muted">bKash, Nagad, Rocket</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 px-4 py-3">
                            <h5 class="mb-0"><i class="fa-solid fa-receipt me-2"></i>Order Summary</h5>
                        </div>
                        <div class="card-body px-4">
                            <div style="max-height: 260px; overflow-y: auto;" class="mb-4">
                                @foreach($cartItems ?? [] as $item)
                                <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                    <div class="me-3" style="width:60px;height:60px;">
                                        <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}"
                                             alt="{{ $item->name }}" class="img-fluid rounded"
                                             onerror="this.src='https://via.placeholder.com/60?text=No+Image'">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0" style="font-size: 14px;">{{ Str::limit($item->name, 25) }}</h6>
                                            <span class="badge bg-primary rounded-pill ms-2">{{ $item->qty }}</span>
                                        </div>
                                        @if($item->options->variant ?? false)
                                            <small class="text-muted">{{ $item->options->variant }}</small>
                                        @endif
                                        <div class="mt-1">
                                            <span class="fw-semibold">৳{{ number_format($item->price * $item->qty, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span id="subtotalAmount">৳{{ number_format($subtotal ?? 0, 2) }}</span>
                            </div>
                            @if(($discount ?? 0) > 0)
                                <div id="discountRow" class="d-flex justify-content-between mb-2 text-success">
                                    <span>Discount</span>
                                    <span id="discountAmount">-৳{{ number_format($discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping</span>
                                <span id="shippingAmount">{{ ($shipping ?? 0) > 0 ? '৳' . number_format($shipping, 2) : 'Free' }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold">Total</span>
                                <span id="totalAmount" class="fw-bold fs-5">৳{{ number_format($total ?? 0, 2) }}</span>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-2">
                                <i class="fa-solid fa-lock me-2"></i>Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
