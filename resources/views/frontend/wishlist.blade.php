@extends('layouts.frontend')

@section('title', 'My Wishlist - GrowUp E-Commerce')

@section('content')
<!-- Wishlist Banner -->
<section class="common-banner">
   <div class="container">
      <div class="row">
         <div class="common-banner__content text-center">
            <span class="sub-title"><i class="fa-solid fa-heart"></i>Your Favorite Products</span>
            <h2 class="title-animation">My Wishlist</h2>
         </div>
      </div>
   </div>
   <div class="banner-bg">
      <img src="{{ asset('frontend/assets/images/banner/banner-bg.png') }}" alt="Image">
   </div>
</section>

<!-- Wishlist Section -->
<section class="shop py-5">
   <div class="container">
      @if($products->count() > 0)
      <div class="row mb-4">
         <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
               <div>
                  <h3 class="mb-0">
                     <i class="fa-solid fa-heart text-danger me-2"></i>
                     My Wishlist
                     <span class="badge bg-danger">{{ $products->count() }}</span>
                  </h3>
               </div>
               <form action="{{ route('wishlist.clear') }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger btn-sm" 
                     onclick="return confirm('Clear your entire wishlist?')">
                     <i class="fa-solid fa-trash me-1"></i>Clear Wishlist
                  </button>
               </form>
            </div>
         </div>
      </div>

      <!-- Products Grid -->
      <div class="row">
         @foreach($products as $product)
         @include('frontend.partials.product-card-template', ['product' => $product, 'colClass' => 'col-12 col-md-6 col-lg-4 mb-5'])
         @endforeach
      </div>

      @else
      <!-- Empty Wishlist State -->
      <div class="row">
         <div class="col-12">
            <div class="text-center py-5">
               <div class="mb-4">
                  <i class="fa-regular fa-heart text-muted" style="font-size: 100px; opacity: 0.5;"></i>
               </div>
               <h2 class="mb-3 fw-bold">Your wishlist is empty</h2>
               <p class="text-muted mb-4 fs-5">Start adding products you love to your wishlist!</p>
               <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                  <i class="fa-solid fa-shopping-bag me-2"></i>Browse Products
               </a>
            </div>
         </div>
      </div>
      @endif
   </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
   const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

   const showToast = (type, message) => {
      const toast = document.createElement('div');
      toast.className = `toast-notification toast-${type}`;
      toast.innerHTML = `
         <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
         ${message}
      `;
      document.body.appendChild(toast);

      setTimeout(() => toast.classList.add('show'), 100);
      setTimeout(() => {
         toast.classList.remove('show');
         setTimeout(() => toast.remove(), 300);
      }, 3000);
   };

   document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', e => {
         e.preventDefault();
         const productId = btn.dataset.id;

         fetch('/cart/add', {
            method: 'POST',
            headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': csrfToken,
               'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
         })
         .then(response => response.json())
         .then(data => {
            if (data.success) {
               showToast('success', data.message ?? 'Product added to cart');
               setTimeout(() => location.reload(), 500);
            } else {
               showToast('error', data.message ?? 'Could not add to cart');
            }
         })
         .catch(() => showToast('error', 'Something went wrong.'));
      });
   });

   document.querySelectorAll('.add-to-wishlist').forEach(btn => {
      btn.addEventListener('click', e => {
         e.preventDefault();
         const productId = btn.dataset.id;

         fetch(`/wishlist/remove/${productId}`, {
            method: 'DELETE',
            headers: {
               'X-CSRF-TOKEN': csrfToken,
               'Accept': 'application/json'
            }
         })
         .then(response => response.json())
         .then(data => {
            if (data.success) {
               showToast('success', data.message ?? 'Removed from wishlist');
               setTimeout(() => location.reload(), 500);
            } else {
               showToast('error', data.message ?? 'Could not remove from wishlist');
            }
         })
         .catch(() => showToast('error', 'Something went wrong.'));
      });
   });
});
</script>
@endpush

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
        border: none;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .toast-notification {
        position: fixed;
        top: 100px;
        right: 20px;
        padding: 15px 25px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        z-index: 9999;
        transform: translateX(120%);
        transition: transform 0.3s ease;
    }
    .toast-notification.show {
        transform: translateX(0);
    }
    .toast-success {
        border-left: 4px solid #28a745;
    }
    .toast-success i {
        color: #28a745;
    }
    .toast-error {
        border-left: 4px solid #dc3545;
    }
    .toast-error i {
        color: #dc3545;
    }
</style>
@endpush

