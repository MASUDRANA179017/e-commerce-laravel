@extends('layouts.frontend')

@section('title', 'Shopping Cart - GrowUp E-Commerce')

@section('content')
<!-- ==== banner section start ==== -->
<section class="common-banner">
   <div class="container">
      <div class="row">
         <div class="common-banner__content text-center">
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
<!-- ==== / banner section end ==== -->

<!-- ==== cart section start ==== -->
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
                                    <img src="{{ asset('storage/' . ($item->options->image ?? 'product/default.png')) }}" alt="{{ $item->name }}" onerror="this.src='{{ asset('frontend/assets/images/shop/cart-three.png') }}'>
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
                                 <small class="text-muted d-block mt-1">
                                    <i class="fa-solid fa-tag me-1"></i>
                                    Price Range: <span class="fw-semibold">{{ $item->price_range }}</span>
                                 </small>
                                 @endif
                              </div>
                           </div>
                        </td>
                        <td>
                           @if(isset($item->original_price) && $item->original_price > $item->price)
                              <div class="d-flex align-items-center gap-2">
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
                  <a href="{{ route('shop.index') }}" class="cart-btn-style h-30px w-175px fs-15 fw-500 px-4 rounded-3">Return To Shop</a>
                  <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="cart-btn-style h-30px w-175px fs-15 fw-500 px-4 rounded-3" onclick="return confirm('Clear all items?')">Clear Cart</button>
                  </form>
               </div>
               <div class="coupon-wrapper qb-bg-base-20 p-3">
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
                           title="apply coupon" class="cart-btn-style h-40px w-200px fs-15 fw-500 px-4 rounded-3">Apply Coupon
                        </button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-4">
            <div class="cart-main__content">
               <!-- Shipping section removed -->
               <div class="cart-main__single  qb-bg-base-10 rounded-3 shadow-sm" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  <div class="intro">
                     <h6>Total Cart</h6>
                  </div>
                  <div class="content">
                     <div class="content-single bg-white rounded-3 p-2 px-3">
                        <p class="m-0">Subtotal</p>
                        <p class="m-0">৳{{ number_format($cartItems->sum(function($item){ return $item->price * $item->qty; }), 0) }}</p>
                     </div>
                     @if(isset($discount) && $discount > 0)
                     <div class="content-single bg-white rounded-3 p-2 px-3">
                        <p class="m-0">Discount</p>
                        <p class="m-0">-৳{{ number_format($discount, 0) }}</p>
                     </div>
                     @endif
                     <!-- Shipping row removed -->
                     <div class="content-single bg-white rounded-3 p-2 px-3">
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
      @endif
   </div>
</section>
<!-- ==== cart section end ==== -->
@endsection
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
      </style>
      @endpush
