@extends('themes.theme2.layouts.frontend')

@section('title', 'Shopping Cart - GrowUp E-Commerce')

@section('content')
<section class="common-banner">
   <div class="container">
      <div class="row">
         <div class="text-center common-banner__content">
            <span class="sub-title"><i class="icon-donation"></i>Start shopping with us</span>
            <h2 class="title-animation">View Cart</h2>
         </div>
      </div>
   </div>
</section>

@php
    if (!isset($cartItems) || count($cartItems) === 0) {
        $rawCart = session()->get('cart', []);
        $cartItems = collect($rawCart)->map(function ($item, $rowId) {
            $product = \App\Models\Product::find($item['id'] ?? null);
            return (object) array_merge($item, [
                'rowId' => $rowId,
                'options' => (object) ($item['options'] ?? []),
                'price_range' => $product ? $product->formatted_price_range : null,
                'original_price' => $item['original_price'] ?? ($product ? $product->price : ($item['price'] ?? 0)),
            ]);
        });

        $subtotal = $cartItems->sum(function ($item) {
            return ($item->price ?? 0) * ($item->qty ?? 0);
        });

        if (!isset($discount)) {
            $discount = session()->get('discount', 0);
        }
        if (!isset($shipping)) {
            $shipping = $subtotal >= 5000 ? 0 : 100;
        }
        if (!isset($total)) {
            $total = $subtotal - $discount + $shipping;
        }
    }
@endphp

<section class="py-5" style="background-color:#f9fafb;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="border-0 shadow-sm card">
                        <div class="px-4 py-3 bg-white border-0 card-header">
                            <h5 class="mb-0">Shopping Cart</h5>
                        </div>
                        <div class="p-0 card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3" style="width:60px;height:60px;">
                                                            <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}">
                                                                <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}"
                                                                     alt="{{ $item->name }}"
                                                                     class="rounded img-fluid"
                                                                     onerror="this.src='{{ asset('frontend/assets/images/shop/cart-three.png') }}'">
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}" class="fw-semibold d-block">
                                                                {{ $item->name }}
                                                            </a>
                                                            @if($item->options->variant)
                                                                <small class="text-muted d-block">{{ $item->options->variant }}</small>
                                                            @endif
                                                            @if($item->price_range)
                                                                <small class="text-muted d-block">
                                                                    <i class="fa-solid fa-tag me-1"></i>
                                                                    Price Range: <span class="fw-semibold">{{ $item->price_range }}</span>
                                                                </small>
                                                            @endif
                                                            <form action="{{ route('cart.remove', $item->rowId) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="p-0 mt-1 btn btn-link text-danger small"
                                                                        onclick="return confirm('Remove this item?')">
                                                                    <i class="fa-solid fa-circle-xmark me-1"></i>Remove
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    @if(isset($item->original_price) && $item->original_price > $item->price)
                                                        <div class="d-flex flex-column align-items-end">
                                                            <span class="fw-semibold">৳{{ number_format($item->price, 0) }}</span>
                                                            <span class="text-muted text-decoration-line-through small">
                                                                ৳{{ number_format($item->original_price, 0) }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <span>৳{{ number_format($item->price, 0) }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-secondary quantity-decrease update-qty"
                                                                data-action="decrease" data-rowid="{{ $item->rowId }}">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                        <span class="px-2 align-self-center item-quantity">{{ $item->qty }}</span>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-secondary quantity-increase update-qty"
                                                                data-action="increase" data-rowid="{{ $item->rowId }}">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <span>৳{{ number_format($item->price * $item->qty, 0) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-white border-0 card-footer d-flex justify-content-between">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left-long me-2"></i>Return To Shop
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                        onclick="return confirm('Clear all items?')">
                                    <i class="fa-solid fa-trash me-1"></i>Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="border-0 shadow-sm card">
                        <div class="px-4 py-3 bg-white border-0 card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="px-4 card-body">
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Subtotal</span>
                                <span>৳{{ number_format($cartItems->sum(function($item){ return $item->price * $item->qty; }), 0) }}</span>
                            </div>
                            @if(isset($discount) && $discount > 0)
                                <div class="mb-2 d-flex justify-content-between">
                                    <span class="text-muted">Discount</span>
                                    <span>-৳{{ number_format($discount, 0) }}</span>
                                </div>
                            @endif
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping</span>
                                <span>{{ ($shipping ?? 0) > 0 ? '৳' . number_format($shipping, 2) : 'Free' }}</span>
                            </div>
                            <hr>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold fs-5">৳{{ number_format($total ?? 0, 0) }}</span>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="py-5 text-center">
                <h3 class="mb-3">Your cart is empty</h3>
                <p class="mb-4 text-muted">Add some products to your cart and come back here.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-danger">
                    <i class="fa-solid fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
