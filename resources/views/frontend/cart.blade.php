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
                           @php
                               $original = $item->options->original_price ?? $item->price;
                               $final = $item->price;
                           @endphp
                           @if($final < $original)
                               <span class="text-danger fw-bold">৳{{ number_format($final, 0) }}</span>
                               <span class="text-decoration-line-through text-muted ms-1">৳{{ number_format($original, 0) }}</span>
                           @else
                               <span class="fw-bold">৳{{ number_format($final, 0) }}</span>
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
                  <a href="{{ route('shop.index') }}" class="create-btn-primary h-30px w-175px fs-15 fw-500 px-4 rounded-3" style="color:#000;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#000'">Return To Shop</a>
                  <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="create-btn-warning h-30px w-175px fs-15 fw-500 px-4 rounded-3" onclick="return confirm('Clear all items?')">Clear Cart</button>
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
                           title="apply coupon" class="create-btn-success h-40px w-200px fs-15 fw-500 px-4 rounded-3">Apply Coupon
                        </button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-4">
            <div class="cart-main__content">
               <div class="cart-main__single aos-init aos-animate qb-bg-teal-10 rounded-3 shadow-sm" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <div class="intro">
                     <h6>Calculate Shipping</h6>
                  </div>
                  <div class="content">
                     <div class="content-single bg-white rounded-3 p-2 px-3">
                        <p class="m-0">Shipping Method</p>
                        <p class="m-0">
                           @if(($shipping ?? 0) > 0)
                           Flat Rate
                           @else
                           Free Shipping
                           @endif
                        </p>
                     </div>
                     <!-- Address details could be added here if available in user session or address object -->
                  </div>
               </div>
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
                     <div class="content-single bg-white rounded-3 p-2 px-3">
                        <p class="m-0">Shipping</p>
                        <p class="m-0">
                           @if(($shipping ?? 0) > 0)
                           ৳{{ number_format($shipping, 0) }}
                           @else
                           Free
                           @endif
                        </p>
                     </div>
                     <div class="content-single bg-white rounded-3 p-2 px-3">
                        <p class="m-0">Total</p>
                        <p class="m-0">৳{{ number_format($total ?? 0, 0) }}</p>
                     </div>
                     <a href="{{ route('checkout.index') }}" aria-label="Checkout" title="Checkout" class="create-btn-success h-35px w-100 fs-15 fw-500">Procced to
                        checkout</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @else
      <div class="row">
         <div class="col-12 text-center py-5">
            <div class="empty-cart-icon mb-4 d-inline-block p-4 rounded-circle bg-light shadow-sm">
               <i class="fa-solid fa-basket-shopping fa-4x text-muted opacity-50"></i>
            </div>
            <h3 class="mb-3 fw-bold text-dark">Your cart is empty</h3>
            <p class="text-muted mb-4 fs-5">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn--primary mt-3">Start Shopping</a>
         </div>
      </div>
      @endif
   </div>
</section>
<!-- ==== cart section end ==== -->
@endsection

@push('scripts')
<script>
   // Format number with commas and no decimals
   function formatPrice(num) {
      return new Intl.NumberFormat('en-US').format(Math.round(num));
   }

   // Update Quantity
   document.querySelectorAll('.update-qty').forEach(function(btn) {
      btn.addEventListener('click', function() {
         var rowId = this.dataset.rowid;
         var action = this.dataset.action;
         var qtySpan = this.parentElement.querySelector('.item-quantity');
         var qty = parseInt(qtySpan.innerText);
         var oldQty = qty;

         if (action === 'increase') {
            qty++;
         } else if (action === 'decrease' && qty > 1) {
            qty--;
         }

         // Optimistic update - update UI immediately
         updateUIInstant(this, qty);

         // Then sync with server
         updateCart(rowId, qty, this);
      });
   });

   function updateUIInstant(button, qty) {
      // Update quantity display instantly
      const qtySpan = button.parentElement.querySelector('.item-quantity');
      qtySpan.innerText = qty;

      // Get price per item
      const cartItemRow = button.closest('.cart-item-single');
      const priceCell = cartItemRow.querySelector('.price');
      const price = parseFloat(priceCell.innerText.replace('৳', '').replace(',', ''));

      // Update item subtotal instantly
      const subtotalCell = cartItemRow.querySelector('.sub');
      const newItemTotal = price * qty;
      subtotalCell.innerText = '৳' + formatPrice(newItemTotal);

      // Update cart totals instantly (calculate from all visible items)
      updateCartTotalsInstant();
   }

   function updateCartTotalsInstant() {
      let totalCartAmount = 0;

      // Sum all visible item subtotals
      document.querySelectorAll('.cart-item-single .sub').forEach(function(el) {
         const amount = parseFloat(el.innerText.replace('৳', '').replace(/,/g, ''));
         totalCartAmount += amount;
      });

      const subtotal = totalCartAmount;
      const shipping = subtotal >= 5000 ? 0 : 100;
      const total = subtotal + shipping;

      // Update display elements
      const contentSingles = document.querySelectorAll('.content-single');

      contentSingles.forEach(el => {
         const text = el.innerText;
         
         if (text.includes('Subtotal') && !text.includes('Discount')) {
            const valueP = el.querySelector('p:last-child');
            if (valueP) valueP.innerText = '৳' + formatPrice(subtotal);
         }

         if (text.includes('Shipping')) {
            const valueP = el.querySelector('p:last-child');
            if (valueP) {
               valueP.innerText = shipping > 0 ? '৳' + formatPrice(shipping) : 'Free';
            }
         }

         if (text.match(/^Total$/)) {
            const valueP = el.querySelector('p:last-child');
            if (valueP) valueP.innerText = '৳' + formatPrice(total);
         }
      });
   }

   function updateCart(rowId, qty, button) {
      fetch(`/cart/update/${rowId}`, {
            method: 'PATCH',
            headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
               quantity: qty
            })
         })
         .then(response => response.json())
         .then(data => {
            if (data.success) {
               // Verify with server response
               const contentSingles = document.querySelectorAll('.content-single');
               contentSingles.forEach(el => {
                  const text = el.innerText;
                  
                  if (text.includes('Subtotal') && !text.includes('Discount')) {
                     const valueP = el.querySelector('p:last-child');
                     if (valueP) valueP.innerText = '৳' + formatPrice(data.subtotal);
                  }

                  if (text.includes('Total') && text.match(/^Total$/)) {
                     const valueP = el.querySelector('p:last-child');
                     if (valueP) valueP.innerText = '৳' + formatPrice(data.total);
                  }
               });
            }
         })
         .catch(error => {
            console.error('Error updating cart:', error);
         });
   }
</script>
@endpush