@extends('layouts.frontend')

@section('title', 'My Wishlist - GrowUp E-Commerce')

@section('content')
<!-- Breadcrumb Section -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Wishlist Section -->
<section class="wishlist-section py-5">
    <div class="container">
        <h1 class="mb-4 fw-bold">
            <i class="fa-solid fa-heart text-danger me-2"></i>My Wishlist
            <span class="badge bg-danger">{{ $products->count() }}</span>
        </h1>

        @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            @php
                $isOnSale = $product->sale_price && $product->sale_price < $product->price;
                $effectivePrice = $isOnSale ? $product->sale_price : $product->price;
                $inStock = ($product->stock_quantity ?? 0) > 0;
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" id="wishlist-item-{{ $product->id }}">
                <div class="card h-100 shadow-sm product-card">
                    <!-- Product Image -->
                    <div class="position-relative">
                        <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                            @if($product->cover_image)
                                <img src="{{ asset('storage/' . $product->cover_image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->title }}"
                                     style="height: 220px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x220?text=No+Image" 
                                     class="card-img-top" 
                                     alt="{{ $product->title }}"
                                     style="height: 220px; object-fit: cover;">
                            @endif
                        </a>
                        
                        <!-- Badges -->
                        <div class="position-absolute top-0 start-0 p-2">
                            @if($isOnSale)
                                <span class="badge bg-danger">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </span>
                            @endif
                        </div>

                        <!-- Remove from Wishlist -->
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle remove-wishlist-item"
                                data-product-id="{{ $product->id }}"
                                title="Remove from Wishlist">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body d-flex flex-column">
                        @if($product->brand_name)
                        <small class="text-muted">{{ $product->brand_name }}</small>
                        @endif
                        
                        <h6 class="card-title mt-1">
                            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($product->title, 40) }}
                            </a>
                        </h6>
                        
                        <!-- Price -->
                        <div class="mb-3">
                            @if($isOnSale)
                                <span class="text-danger fw-bold fs-5">৳{{ number_format($product->sale_price, 0) }}</span>
                                <span class="text-muted text-decoration-line-through ms-2">৳{{ number_format($product->price, 0) }}</span>
                            @else
                                <span class="text-primary fw-bold fs-5">৳{{ number_format($product->price ?? 0, 0) }}</span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <p class="mb-3">
                            @if($inStock)
                                <span class="text-success"><i class="fa-solid fa-check-circle me-1"></i> In Stock</span>
                            @else
                                <span class="text-danger"><i class="fa-solid fa-times-circle me-1"></i> Out of Stock</span>
                            @endif
                        </p>

                        <!-- Actions -->
                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-primary flex-grow-1 move-to-cart"
                                    data-product-id="{{ $product->id }}"
                                    {{ !$inStock ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                            </button>
                            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-end mt-4">
            <form action="{{ route('wishlist.clear') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to clear your wishlist?')">
                    <i class="fa-solid fa-trash me-1"></i> Clear Wishlist
                </button>
            </form>
        </div>

        @else
        <!-- Empty Wishlist -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fa-regular fa-heart text-muted" style="font-size: 80px;"></i>
            </div>
            <h3 class="mb-3">Your wishlist is empty</h3>
            <p class="text-muted mb-4">Start adding products you love!</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-shopping-bag me-2"></i> Browse Products
            </a>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Remove from wishlist
    document.querySelectorAll('.remove-wishlist-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            fetch(`/wishlist/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`wishlist-item-${productId}`).remove();
                    
                    // Check if wishlist is empty
                    if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
                        location.reload();
                    }
                    
                    // Show toast
                    showToast('success', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Move to cart
    document.querySelectorAll('.move-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            fetch(`/wishlist/move-to-cart/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`wishlist-item-${productId}`).remove();
                    
                    // Update cart count
                    const cartBadge = document.querySelector('.cart-count');
                    if (cartBadge) {
                        cartBadge.textContent = data.cartCount;
                    }
                    
                    // Check if wishlist is empty
                    if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
                        location.reload();
                    }
                    
                    // Show toast
                    showToast('success', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    function showToast(type, message) {
        // Create toast element
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
    }
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

