@extends('layouts.frontend')

@section('title', 'Shopping Cart - GrowUp E-Commerce')

@section('content')
<!-- Banner Section -->
<section class="common-banner" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="common-banner__content text-center">
                <span class="sub-title"><i class="fa-solid fa-shopping-cart"></i> Your Cart</span>
                <h2 class="title-animation" style="font-size: 36px;">Shopping Cart</h2>
                <nav aria-label="breadcrumb" class="mt-3">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="cart-main py-5">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="cart-items-wrapper bg-white rounded-4 shadow-sm p-4" data-aos="fade-up">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 rounded-start">Product</th>
                                    <th class="border-0">Price</th>
                                    <th class="border-0">Quantity</th>
                                    <th class="border-0">Subtotal</th>
                                    <th class="border-0 rounded-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr class="cart-item-row" data-rowid="{{ $item->rowId }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="cart-item-image me-3" style="width: 80px; height: 80px; border-radius: 10px; overflow: hidden;">
                                                <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}">
                                                    <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}" alt="{{ $item->name }}" class="img-fluid w-100 h-100" style="object-fit: cover;" onerror="this.src='https://via.placeholder.com/80?text=No+Image'">
                                                </a>
                                            </div>
                                            <div class="cart-item-info">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}" class="text-dark text-decoration-none">
                                                        {{ Str::limit($item->name, 30) }}
                                                    </a>
                                                </h6>
                                                @if($item->options->variant ?? false)
                                                <small class="text-muted">{{ $item->options->variant }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold">৳{{ number_format($item->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <div class="quantity-control d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-secondary update-qty" data-action="decrease" data-rowid="{{ $item->rowId }}">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control form-control-sm text-center mx-2 qty-input" value="{{ $item->qty }}" min="1" style="width: 60px;" data-rowid="{{ $item->rowId }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary update-qty" data-action="increase" data-rowid="{{ $item->rowId }}">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary item-subtotal">৳{{ number_format($item->price * $item->qty, 2) }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->rowId) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this item from cart?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Actions -->
                    <div class="cart-actions d-flex flex-wrap justify-content-between align-items-center mt-4 pt-4 border-top">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear all items from cart?')">
                                <i class="fa-solid fa-trash me-2"></i>Clear Cart
                            </button>
                        </form>
                    </div>

                    <!-- Coupon Code -->
                    <div class="coupon-section mt-4 p-4 bg-light rounded-3">
                        <h6 class="mb-3"><i class="fa-solid fa-ticket me-2"></i>Have a Coupon?</h6>
                        <form action="{{ route('cart.coupon') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="coupon_code" class="form-control" placeholder="Enter coupon code" value="{{ session('coupon_code') }}">
                            <button type="submit" class="btn btn-primary px-4">Apply</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="cart-summary bg-white rounded-4 shadow-sm p-4" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="mb-4 pb-3 border-bottom">Order Summary</h5>
                    
                    <div class="summary-item d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">৳{{ number_format($subtotal ?? 0, 2) }}</span>
                    </div>
                    
                    @if(($discount ?? 0) > 0)
                    <div class="summary-item d-flex justify-content-between mb-3 text-success">
                        <span>Discount</span>
                        <span class="fw-bold">-৳{{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="summary-item d-flex justify-content-between mb-3">
                        <span class="text-muted">Shipping</span>
                        <span class="fw-bold">
                            @if(($shipping ?? 0) > 0)
                                ৳{{ number_format($shipping, 2) }}
                            @else
                                <span class="text-success">Free</span>
                            @endif
                        </span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-total d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-4 text-primary">৳{{ number_format($total ?? 0, 2) }}</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 mb-3">
                        <i class="fa-solid fa-lock me-2"></i>Proceed to Checkout
                    </a>
                    
                    <div class="secure-checkout text-center">
                        <small class="text-muted">
                            <i class="fa-solid fa-shield-halved me-1"></i>Secure Checkout
                        </small>
                    </div>
                    
                    <!-- Payment Methods -->
                    <div class="payment-methods text-center mt-4 pt-4 border-top">
                        <small class="text-muted d-block mb-2">We Accept</small>
                        <div class="d-flex justify-content-center gap-2">
                            <i class="fab fa-cc-visa fa-2x text-muted"></i>
                            <i class="fab fa-cc-mastercard fa-2x text-muted"></i>
                            <i class="fab fa-cc-amex fa-2x text-muted"></i>
                            <i class="fab fa-cc-paypal fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="empty-cart text-center py-5" data-aos="fade-up">
            <div class="empty-cart-icon mb-4">
                <i class="fa-solid fa-shopping-cart fa-5x text-muted"></i>
            </div>
            <h3 class="mb-3">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="fa-solid fa-shopping-bag me-2"></i>Start Shopping
            </a>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Update Quantity
    document.querySelectorAll('.update-qty').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var rowId = this.dataset.rowid;
            var action = this.dataset.action;
            var input = document.querySelector(`.qty-input[data-rowid="${rowId}"]`);
            var qty = parseInt(input.value);
            
            if (action === 'increase') {
                qty++;
            } else if (action === 'decrease' && qty > 1) {
                qty--;
            }
            
            input.value = qty;
            updateCart(rowId, qty);
        });
    });
    
    // Update on input change
    document.querySelectorAll('.qty-input').forEach(function(input) {
        input.addEventListener('change', function() {
            var rowId = this.dataset.rowid;
            var qty = parseInt(this.value);
            if (qty < 1) qty = 1;
            this.value = qty;
            updateCart(rowId, qty);
        });
    });
    
    function updateCart(rowId, qty) {
        fetch(`/cart/update/${rowId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
@endpush

