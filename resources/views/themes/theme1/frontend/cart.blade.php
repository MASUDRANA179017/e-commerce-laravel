@extends('layouts.frontend')

@section('title', 'Shopping Cart - GrowUp E-Commerce')

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/default-theme.css') }}">
@endpush

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

<section class="common-banner">
   <div class="container">
      <div class="row">
         <div class="text-center common-banner__content">
            <span class="sub-title"><i class="icon-donation"></i>Start shopping with us</span>
            <h2 class="title-animation">View Cart</h2>
         </div>
      </div>
   </div>
   <div class="banner-bg">
      <img src="{{ asset('frontend/assets/images/banner/banner-bg.png') }}" alt="Image">
   </div>
   <div class="shape">
      <img src="{{ asset('frontend/assets/images/shape.png') }}" alt="Image">
   </div>
   <div class="sprade" data-aos="zoom-in" data-aos-duration="1000">
      <img src="{{ asset('frontend/assets/images/sprade-base.png') }}" alt="Image" class="base-img">
   </div>
</section>

<section class="cart-main">
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
      <div class="row gutter-60">
         <div class="col-12 col-xl-8">
            <div class="cart__inner" data-aos="fade-up" data-aos-duration="1000">
               <div class="cart-table">
                  <table>
                     <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                     </tr>
                     @foreach($cartItems as $item)
                     <tr class="cart-item-single">
                        <td class="cart-product">
                           <div class="cart-product-wrapper">
                              <div class="thumb">
                                 <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}">
                                    <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}" alt="{{ $item->name }}" onerror="this.src='{{ asset('frontend/assets/images/shop/cart-three.png') }}'">
                                 </a>
                                 <form action="{{ route('cart.remove', $item->rowId) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="delete item" class="delete-item" onclick="return confirm('Remove this item?')">
                                       <i class="fa-solid fa-circle-xmark"></i>
                                    </button>
                                 </form>
                              </div>
                              <div class="content">
                                 <p><a href="{{ route('product.show', $item->options->slug ?? $item->id) }}">{{ $item->name }}</a></p>
                                 @if($item->options->variant)
                                 <small class="text-muted d-block">{{ $item->options->variant }}</small>
                                 @endif
                                 @if($item->price_range)
                                 <small class="mt-1 text-muted d-block">
                                    <i class="fa-solid fa-tag me-1"></i>
                                    Price Range: <span class="fw-semibold">{{ $item->price_range }}</span>
                                 </small>
                                 @endif
                              </div>
                           </div>
                        </td>
                        <td>
                           @if(isset($item->original_price) && $item->original_price > $item->price)
                              <div class="gap-2 d-flex align-items-center">
                                 <span class="text-dark fw-bold">৳{{ number_format($item->price, 0) }}</span>
                                 <span class="text-decoration-line-through text-muted small">৳{{ number_format($item->original_price, 0) }}</span>
                              </div>
                           @else
                              <span class="price">৳{{ number_format($item->price, 0) }}</span>
                           @endif
                        </td>
                        <td>
                           <div class="measure">
                              <button type="button" aria-label="decrease item" class="quantity-decrease update-qty" data-action="decrease" data-rowid="{{ $item->rowId }}">
                                 <i class="fa-solid fa-minus"></i>
                              </button>
                              <span class="item-quantity">{{ $item->qty }}</span>
                              <button type="button" aria-label="add item" class="quantity-increase update-qty" data-action="increase" data-rowid="{{ $item->rowId }}">
                                 <i class="fa-solid fa-plus"></i>
                              </button>
                           </div>
                        </td>
                        <td>
                           <p class="sub">৳{{ number_format($item->price * $item->qty, 0) }}</p>
                        </td>
                     </tr>
                     @endforeach
                  </table>
               </div>
               <div class="update-cart qb-bg-teal-10">
                  <a href="{{ route('shop.index') }}" class="px-4 cart-btn-style h-30px w-175px fs-15 fw-500 rounded-3">Return To Shop</a>
                  <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="px-4 cart-btn-style h-30px w-175px fs-15 fw-500 rounded-3" onclick="return confirm('Clear all items?')">Clear Cart</button>
                  </form>
               </div>
               <div class="p-3 coupon-wrapper qb-bg-base-20">
                  <div class="left-c">
                     <h6>Coupon Code</h6>
                  </div>
                  <div class="right-c">
                     <form action="{{ route('cart.coupon') }}" method="post">
                        @csrf
                        <div class="input-single">
                           <input type="text" required name="coupon_code" id="cCcode" placeholder="Enter Coupon">
                        </div>
                        <button type="submit" aria-label="apply coupon"
                           title="apply coupon" class="px-4 cart-btn-style h-40px w-200px fs-15 fw-500 rounded-3">Apply Coupon
                        </button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-4">
            <div class="cart-main__content">
               <div class="shadow-sm cart-main__single qb-bg-base-10 rounded-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  <div class="intro">
                     <h6>Total Cart</h6>
                  </div>
                  <div class="content">
                     <div class="p-2 px-3 bg-white content-single rounded-3">
                        <p class="m-0">Subtotal</p>
                        <p class="m-0">৳{{ number_format($cartItems->sum(function($item){ return $item->price * $item->qty; }), 0) }}</p>
                     </div>
                     @if(isset($discount) && $discount > 0)
                     <div class="p-2 px-3 bg-white content-single rounded-3">
                        <p class="m-0">Discount</p>
                        <p class="m-0">-৳{{ number_format($discount, 0) }}</p>
                     </div>
                     @endif
                     <div class="p-2 px-3 bg-white content-single rounded-3">
                        <p class="m-0">Total</p>
                        <p class="m-0">৳{{ number_format($total ?? 0, 0) }}</p>
                     </div>
                     <a href="{{ route('checkout.index') }}" aria-label="Checkout" title="Checkout" class="cart-btn-style h-35px w-100 fs-15 fw-500">Procced to
                        checkout</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @else
      <div class="text-center py-5">
         <h3 class="mb-3">Your cart is empty</h3>
         <p class="text-muted mb-4">Add some products to your cart and come back here.</p>
         <a href="{{ route('shop.index') }}" class="cart-btn-style h-35px w-200px fs-15 fw-500">Browse Products</a>
      </div>
      @endif
   </div>
</section>

@push('styles')
   <style>
   .cart-btn-style {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-top: 20px;
      background: var(--apece-primary) !important;
      color: {{ $themeButtonTextColor ?? '#fff' }};
      font-weight: 600;
      border: none;
      border-radius: 30px;
      padding: 0.75em 2em;
      font-size: 1rem;
      transition: background 0.2s, color 0.2s;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
   }
   .cart-btn-style:hover {
      background: {{ $themeSecondary ?? '#1a1a2e' }};
      color: #fff;
   }
   .quantity-decrease, .quantity-increase {
      background: var(--apece-primary) !important;
      color: #fff !important;
      border: none !important;
      border-radius: 50% !important;
      width: 32px;
      height: 32px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      transition: background 0.2s;
   }
   .quantity-decrease:hover, .quantity-increase:hover {
      background: var(--apece-secondary) !important;
   }
   .cart-main {
      background-color: #f9fafb !important;
      color: #111827 !important;
   }
   .cart-main .cart__inner,
   .cart-main .cart-main__single,
   .cart-main .coupon-wrapper {
      background-color: #ffffff !important;
   }
   .cart-main table th,
   .cart-main table td,
   .cart-main p,
   .cart-main span,
   .cart-main a,
   .cart-main h1,
   .cart-main h2,
   .cart-main h3,
   .cart-main h4,
   .cart-main h5,
   .cart-main h6 {
      color: #111827 !important;
   }
   </style>
@endpush
@endsection
