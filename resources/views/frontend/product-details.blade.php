@extends('layouts.frontend')

@section('title', ($product->title ?? $product->name ?? 'Product Details') . ' - GrowUp E-Commerce')

@section('content')
<!-- Breadcrumb Section -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
                @if($product->categories && $product->categories->count() > 0)
                    <li class="breadcrumb-item"><a href="{{ route('shop.index', ['category' => $product->categories->first()->name]) }}">{{ $product->categories->first()->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->title ?? $product->name ?? 'Product' }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Product Details Section -->
<section class="product-details py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                <div class="product-images">
                    <!-- Main Image -->
                    <div class="main-image mb-3 position-relative overflow-hidden rounded-4" style="background: #f8f9fa;">
                        @if(isset($product->images) && $product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->title ?? 'Product' }}" class="img-fluid w-100" id="mainProductImage" style="max-height: 500px; object-fit: contain;">
                        @elseif($product->coverImage)
                            <img src="{{ asset('storage/' . $product->coverImage->image) }}" alt="{{ $product->title ?? 'Product' }}" class="img-fluid w-100" id="mainProductImage" style="max-height: 500px; object-fit: contain;">
                        @else
                            <img src="https://via.placeholder.com/500x500?text=No+Image" alt="{{ $product->title ?? 'Product' }}" class="img-fluid w-100" id="mainProductImage" style="max-height: 500px; object-fit: contain;">
                        @endif
                        
                        <!-- Badges -->
                        <div class="position-absolute top-0 start-0 p-3">
                            @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                                <span class="badge bg-primary me-1">New</span>
                            @endif
                            @if(isset($product->sale_price) && $product->sale_price && $product->sale_price < $product->price)
                                @php $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
                                <span class="badge bg-danger">-{{ $discountPercent }}% OFF</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    @if(isset($product->images) && $product->images->count() > 1)
                    <div class="thumbnail-gallery d-flex gap-2 flex-wrap">
                        @foreach($product->images as $index => $image)
                        <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}" style="width: 80px; height: 80px; cursor: pointer; border: 2px solid {{ $index == 0 ? '#0496ff' : '#eee' }}; border-radius: 8px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->title ?? 'Product' }}" class="img-fluid w-100 h-100" style="object-fit: cover;" onclick="changeMainImage(this, '{{ asset('storage/' . $image->image) }}')">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-12 col-lg-7">
                <div class="product-info" data-aos="fade-up">
                    <!-- Product Title -->
                    <h1 class="product-title mb-3" style="font-size: 32px; font-weight: 700;">{{ $product->title ?? $product->name ?? 'Product Name' }}</h1>
                    
                    <!-- Rating -->
                    <div class="product-rating d-flex align-items-center gap-3 mb-3">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= ($product->average_rating ?? 4) ? 'solid' : 'regular' }} fa-star text-warning"></i>
                            @endfor
                        </div>
                        <span class="text-muted">({{ $product->reviews_count ?? 0 }} Reviews)</span>
                        <span class="text-success"><i class="fa-solid fa-check-circle"></i> In Stock</span>
                    </div>

                    <!-- Price -->
                    <div class="product-price mb-4">
                        @php
                            $price = 0;
                            $salePrice = null;
                            $stock = 0;
                            if ($product->variants && $product->variants->count() > 0) {
                                $variant = $product->variants->first();
                                $price = $variant->price ?? 0;
                                $salePrice = $variant->sale_price ?? null;
                                $stock = $product->variants->sum('stock') ?? 0;
                            } elseif (isset($product->price)) {
                                $price = $product->price;
                                $salePrice = $product->sale_price ?? null;
                                $stock = $product->stock ?? 0;
                            }
                        @endphp
                        @if($salePrice && $salePrice < $price)
                            <span class="current-price text-danger" style="font-size: 36px; font-weight: 700;">${{ number_format($salePrice, 2) }}</span>
                            <span class="original-price text-muted text-decoration-line-through ms-2" style="font-size: 24px;">${{ number_format($price, 2) }}</span>
                            <span class="badge bg-danger ms-2">Save ${{ number_format($price - $salePrice, 2) }}</span>
                        @else
                            <span class="current-price" style="font-size: 36px; font-weight: 700; color: #0496ff;">${{ number_format($price, 2) }}</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <div class="product-description mb-4">
                        <p class="text-muted">{{ $product->short_desc ?? $product->short_description ?? 'No description available.' }}</p>
                    </div>

                    <!-- Product Meta -->
                    <div class="product-meta mb-4 p-3 bg-light rounded">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <strong>SKU:</strong> <span class="text-muted">{{ $product->slug ?? 'N/A' }}</span>
                            </div>
                            <div class="col-6 mb-2">
                                <strong>Category:</strong> 
                                @if($product->categories && $product->categories->count() > 0)
                                    <a href="{{ route('shop.index', ['category' => $product->categories->first()->name]) }}">{{ $product->categories->first()->name }}</a>
                                @else
                                    <span class="text-muted">Uncategorized</span>
                                @endif
                            </div>
                            <div class="col-6 mb-2">
                                <strong>Brand:</strong> <span class="text-muted">{{ $product->brand->name ?? 'N/A' }}</span>
                            </div>
                            <div class="col-6 mb-2">
                                <strong>Availability:</strong> 
                                @if($stock > 0)
                                    <span class="text-success">{{ $stock }} in stock</span>
                                @else
                                    <span class="text-danger">Out of stock</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Quantity Selector -->
                        <div class="quantity-selector d-flex align-items-center gap-3 mb-4">
                            <label class="mb-0 fw-bold">Quantity:</label>
                            <div class="input-group" style="width: 140px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $stock > 0 ? $stock : 99 }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons d-flex flex-wrap gap-3 mb-4">
                            <button type="submit" class="btn btn-success btn-lg px-5" {{ $stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-shopping-cart me-2"></i> Add to Cart
                            </button>
                            <button type="button" class="btn btn-primary btn-lg px-5 buy-now-btn" {{ $stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-bolt me-2"></i> Buy Now
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-lg add-to-wishlist" data-product-id="{{ $product->id }}">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Social Share -->
                    <div class="social-share pt-3 border-top">
                        <strong class="me-3">Share:</strong>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->title ?? '') }}" target="_blank" class="btn btn-sm btn-outline-info me-2">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode(($product->title ?? '') . ' ' . request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-success me-2">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($product->title ?? '') }}" target="_blank" class="btn btn-sm btn-outline-danger">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Tabs Section -->
<section class="product-tabs py-5 bg-light">
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                            <i class="fa-solid fa-file-lines me-2"></i>Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                            <i class="fa-solid fa-list-check me-2"></i>Specifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                            <i class="fa-solid fa-star me-2"></i>Reviews ({{ $product->reviews_count ?? 0 }})
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="product-description">
                            {!! $product->description ?? '<p>No description available for this product.</p>' !!}
                        </div>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div class="tab-pane fade" id="specifications" role="tabpanel">
                        <table class="table table-striped">
                            <tbody>
                                <tr><th width="200">SKU</th><td>{{ $product->slug ?? 'N/A' }}</td></tr>
                                <tr><th>Category</th><td>{{ $product->categories && $product->categories->count() > 0 ? $product->categories->first()->name : 'N/A' }}</td></tr>
                                <tr><th>Brand</th><td>{{ $product->brand->name ?? 'N/A' }}</td></tr>
                                @if($product->weight ?? false)
                                <tr><th>Weight</th><td>{{ $product->weight }} kg</td></tr>
                                @endif
                                @if($product->dimensions ?? false)
                                <tr><th>Dimensions</th><td>{{ $product->dimensions }}</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        @if(isset($product->reviews) && $product->reviews->count() > 0)
                            @foreach($product->reviews as $review)
                            <div class="review-item mb-4 pb-4 border-bottom">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/50" alt="{{ $review->user->name ?? 'User' }}" class="rounded-circle me-3">
                                        <div>
                                            <h6 class="mb-0">{{ $review->user->name ?? 'Anonymous' }}</h6>
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-warning small"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $review->comment }}</p>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                        @endif

                        @auth
                        <div class="write-review mt-4 pt-4 border-top">
                            <h5 class="mb-3">Write a Review</h5>
                            <form action="{{ route('product.review', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Your Rating *</label>
                                    <div class="rating-stars">
                                        @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                        <label for="star{{ $i }}"><i class="fa-solid fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Your Review *</label>
                                    <textarea name="comment" class="form-control" rows="4" required placeholder="Write your review here..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                        @else
                        <div class="mt-4 pt-4 border-top">
                            <p><a href="{{ route('login') }}">Login</a> to write a review.</p>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products Section -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section class="related-products py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sub-title-main"><i class="fa-solid fa-link"></i> You May Also Like</span>
            <h2 class="title-animation">Related <span>Products</span></h2>
        </div>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                @include('frontend.partials.product-card', ['product' => $relatedProduct])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating-stars input {
        display: none;
    }
    .rating-stars label {
        cursor: pointer;
        font-size: 24px;
        color: #ddd;
        padding: 0 5px;
    }
    .rating-stars label:hover,
    .rating-stars label:hover ~ label,
    .rating-stars input:checked ~ label {
        color: #ffc107;
    }
    
    .thumbnail-item.active {
        border-color: #0496ff !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function changeMainImage(element, src) {
        document.getElementById('mainProductImage').src = src;
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
            item.style.borderColor = '#eee';
        });
        element.parentElement.classList.add('active');
        element.parentElement.style.borderColor = '#0496ff';
    }
    
    function increaseQty() {
        var input = document.getElementById('quantity');
        var max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    
    function decreaseQty() {
        var input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    // Buy Now Button
    document.querySelector('.buy-now-btn')?.addEventListener('click', function() {
        var form = document.getElementById('add-to-cart-form');
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'buy_now';
        input.value = '1';
        form.appendChild(input);
        form.submit();
    });
</script>
@endpush

