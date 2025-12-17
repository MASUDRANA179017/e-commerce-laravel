@extends('layouts.frontend')

@section('title', 'Shopping Cart - GrowUp E-Commerce')

@section('content')
<!-- Banner Section -->
<section class="common-banner" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('frontend/images/banner/banner1.jpg') }}') no-repeat center center/cover; padding: 80px 0;">
    <div class="container">
        <div class="row">
            <div class="common-banner__content text-center text-white">
                <span class="sub-title d-block mb-2 text-uppercase fw-bold" style="letter-spacing: 2px; color: #ffc107;"><i class="fa-solid fa-shopping-bag me-2"></i>Your Shopping Bag</span>
                <h2 class="title-animation fw-bold display-4">Cart</h2>
                <nav aria-label="breadcrumb" class="mt-3">
                    <ol class="breadcrumb justify-content-center mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-warning" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="cart-main py-5 bg-light">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-success border-4" role="alert">
            <i class="fa-solid fa-check-circle me-2 text-success"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-danger border-4" role="alert">
            <i class="fa-solid fa-exclamation-circle me-2 text-danger"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="cart-items-wrapper bg-white rounded-4 shadow-sm overflow-hidden" data-aos="fade-up">
                    <div class="p-4 border-bottom">
                        <h4 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-layer-group me-2 text-primary"></i>Items in your cart ({{ count($cartItems) }})</h4>
                    </div>
                    
                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-md-block p-4">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="bg-light text-uppercase small text-muted">
                                <tr>
                                    <th class="border-0 py-3 ps-3 rounded-start">Product Details</th>
                                    <th class="border-0 py-3 text-center">Price</th>
                                    <th class="border-0 py-3 text-center">Quantity</th>
                                    <th class="border-0 py-3 text-end">Subtotal</th>
                                    <th class="border-0 py-3 text-end rounded-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr class="cart-item-row border-bottom-0" data-rowid="{{ $item->rowId }}">
                                    <td class="py-4 ps-3">
                                        <div class="d-flex align-items-center">
                                            <div class="cart-item-image me-4 position-relative shadow-sm rounded-3 overflow-hidden" style="width: 80px; height: 80px;">
                                                <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}">
                                                    <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}" alt="{{ $item->name }}" class="img-fluid w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
                                                </a>
                                            </div>
                                            <div class="cart-item-info">
                                                <h6 class="mb-1 fw-bold">
                                                    <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}" class="text-dark text-decoration-none hover-primary">
                                                        {{ Str::limit($item->name, 40) }}
                                                    </a>
                                                </h6>
                                                @if($item->options->variant ?? false)
                                                <span class="badge bg-light text-dark border mt-1">{{ $item->options->variant }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-dark">৳{{ number_format($item->price, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="quantity-control d-inline-flex align-items-center bg-light rounded-pill p-1 border">
                                            <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 update-qty" data-action="decrease" data-rowid="{{ $item->rowId }}">
                                                <i class="fa-solid fa-minus small"></i>
                                            </button>
                                            <input type="number" class="form-control form-control-sm border-0 bg-transparent text-center fw-bold p-0 qty-input" value="{{ $item->qty }}" min="1" style="width: 40px;" data-rowid="{{ $item->rowId }}">
                                            <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 update-qty" data-action="increase" data-rowid="{{ $item->rowId }}">
                                                <i class="fa-solid fa-plus small"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-primary fs-5 item-subtotal">৳{{ number_format($item->price * $item->qty, 2) }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <form action="{{ route('cart.remove', $item->rowId) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" style="width: 32px; height: 32px;" onclick="return confirm('Remove this item from cart?')" title="Remove Item">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View (Enhanced) -->
                    <div class="d-md-none p-3 bg-light">
                        @foreach($cartItems as $item)
                        <div class="cart-item-card mb-3 bg-white rounded-3 shadow-sm overflow-hidden position-relative">
                            <div class="p-3">
                                <div class="d-flex">
                                    <div class="cart-item-image me-3 rounded-3 overflow-hidden shadow-sm" style="width: 80px; height: 80px; flex-shrink: 0;">
                                        <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}">
                                            <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}" alt="{{ $item->name }}" class="w-100 h-100" style="object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark line-clamp-2" style="font-size: 0.95rem;">
                                                    <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}" class="text-dark text-decoration-none">
                                                        {{ $item->name }}
                                                    </a>
                                                </h6>
                                                @if($item->options->variant ?? false)
                                                <small class="text-muted d-block">{{ $item->options->variant }}</small>
                                                @endif
                                            </div>
                                            <form action="{{ route('cart.remove', $item->rowId) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 ms-2 m-1" onclick="return confirm('Remove this item?')" style="opacity: 0.7;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end mt-2">
                                            <div class="quantity-control d-flex align-items-center bg-light rounded-pill border px-1 m-1" style="height: 32px;">
                                                <button type="button" class="btn btn-sm text-secondary p-0 px-2 update-qty m-1" data-action="decrease" data-rowid="{{ $item->rowId }}">
                                                    <i class="fa-solid fa-minus" style="font-size: 10px;"></i>
                                                </button>
                                                <input type="number" class="form-control form-control-sm border-0 bg-transparent text-center p-0 qty-input fw-bold m-1" value="{{ $item->qty }}" min="1" style="width: 30px; font-size: 14px;" data-rowid="{{ $item->rowId }}">
                                                <button type="button" class="btn btn-sm text-secondary p-0 px-2 update-qty m-1" data-action="increase" data-rowid="{{ $item->rowId }}">
                                                    <i class="fa-solid fa-plus" style="font-size: 10px;"></i>
                                                </button>
                                            </div>
                                            <div class="text-end">
                                                <div class="fw-bold text-primary fs-6 item-subtotal m-1">৳{{ number_format($item->price * $item->qty, 2) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Cart Actions -->
                    <div class="p-4 bg-light border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 m-2">
                            <i class="fa-solid fa-arrow-left-long me-2"></i>Continue Shopping
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4 m-2" onclick="return confirm('Clear all items from cart?')">
                                <i class="fa-solid fa-trash-can me-2"></i>Clear Cart
                            </button>
                        </form>
                    </div>

                    <!-- Coupon Code -->
                    <div class="p-4 border-top bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-tag me-2 text-warning"></i>Have a Coupon Code?</h6>
                                <p class="text-muted small mb-0">Add your coupon code here to get discounts.</p>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('cart.coupon') }}" method="POST" class="position-relative">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="coupon_code" class="form-control rounded-pill ps-4 py-2 bg-light border" placeholder="Enter code here" value="{{ session('coupon_code') }}">
                                        <button type="submit" class="btn btn-dark rounded-pill px-4 position-absolute end-0 top-0 h-100" style="z-index: 5;">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="cart-summary bg-white rounded-4 shadow-sm p-4 position-sticky" style="top: 100px;" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="mb-4 fw-bold text-dark border-bottom pb-3">Order Summary</h5>
                    
                    <div class="summary-item d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-secondary">Subtotal</span>
                        <span class="fw-bold fs-6 text-dark">৳{{ number_format($subtotal ?? 0, 2) }}</span>
                    </div>
                    
                    @if(($discount ?? 0) > 0)
                    <div class="summary-item d-flex justify-content-between mb-3 align-items-center text-success bg-success-subtle p-2 rounded">
                        <span><i class="fa-solid fa-ticket me-1"></i> Discount</span>
                        <span class="fw-bold">-৳{{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="summary-item d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-secondary">Shipping</span>
                        <span class="fw-bold text-dark">
                            @if(($shipping ?? 0) > 0)
                                ৳{{ number_format($shipping, 2) }}
                            @else
                                <span class="text-success badge bg-success-subtle text-success border border-success">Free</span>
                            @endif
                        </span>
                    </div>
                    
                    <hr class="my-4 border-secondary border-opacity-25">
                    
                    <div class="summary-total d-flex justify-content-between mb-4 align-items-center">
                        <span class="fw-bold fs-5 text-dark">Total</span>
                        <span class="fw-bold fs-3 text-primary">৳{{ number_format($total ?? 0, 2) }}</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm mb-3 text-uppercase letter-spacing-1 hover-lift">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right-long ms-2"></i>
                    </a>
                    
                    <div class="secure-checkout text-center bg-light p-2 rounded-3 mb-4">
                        <small class="text-muted fw-semibold">
                            <i class="fa-solid fa-shield-halved me-1 text-success"></i> 100% Secure Checkout
                        </small>
                    </div>
                    
                    <!-- Payment Methods -->
                    <div class="payment-methods text-center">
                        <small class="text-muted d-block mb-3 text-uppercase" style="font-size: 11px; letter-spacing: 1px;">We Accept</small>
                        <div class="d-flex justify-content-center gap-3 opacity-75 grayscale-hover">
                            <i class="fa-brands fa-cc-visa fa-2x"></i>
                            <i class="fa-brands fa-cc-mastercard fa-2x"></i>
                            <i class="fa-brands fa-cc-amex fa-2x"></i>
                            <i class="fa-brands fa-cc-paypal fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="empty-cart text-center py-5" data-aos="fade-up">
            <div class="empty-cart-icon mb-4 d-inline-block p-4 rounded-circle bg-light shadow-sm">
                <i class="fa-solid fa-basket-shopping fa-4x text-muted opacity-50"></i>
            </div>
            <h3 class="mb-3 fw-bold text-dark">Your cart is empty</h3>
            <p class="text-muted mb-4 fs-5">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow hover-lift">
                <i class="fa-solid fa-arrow-left-long me-2"></i>Start Shopping
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

