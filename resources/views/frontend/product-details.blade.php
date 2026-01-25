@extends('layouts.frontend')

@section('title', ($product->title ?? 'Product Details') . ' - GrowUp E-Commerce')

@php

    $productImages = collect();
    if ($product->images && $product->images->count() > 0) {
        $productImages = $product->images->sortByDesc('is_cover');
    }
    $mainImage = $productImages->first();
    $dummyImage = asset('frontend/assets/images/shop/KHPP-SA21 - 1.png');

    $price = $product->price ?? 0;
    $salePrice = $product->sale_price ?? null;
    $flashSalePrice = null;
    $isFlashSale = false;
    if (method_exists($product, 'getActiveFlashSaleAttribute')) {
        $activeFlashSale = $product->active_flash_sale;
        if ($activeFlashSale) {
            $flashSalePrice = $activeFlashSale->pivot->flash_price ?? null;
            $isFlashSale = true;
        }
    }
    $candidates = [$price];
    if ($salePrice && $salePrice < $price) $candidates[] = $salePrice;
    if ($isFlashSale && $flashSalePrice && $flashSalePrice < $price) $candidates[] = $flashSalePrice;
    $finalPrice = min($candidates);
    $originalPrice = $price;
    $isOnSale = $finalPrice < $price;
    $discountPercent = $isOnSale && $price > 0 ? round((($price - $finalPrice) / $price) * 100) : 0;

    $stockQty = $product->stock_quantity ?? 0;
    $inStock = $stockQty > 0 || ($product->allow_backorder ?? false);

    $category = $product->categories && $product->categories->count() > 0 ? $product->categories->first() : null;

    $purchaseMin = $purchaseMin ?? null;
    $purchaseMax = $purchaseMax ?? null;

    // Pre-render short description (supports TinyMCE HTML or plain text)
    $shortDescRaw = $product->short_desc ?? '';
    $shortDescHasMarkup = \Illuminate\Support\Str::contains($shortDescRaw, ['<p', '<br', '<ul', '<ol', '<li', '<div', '<span']);
    $shortDescHtml = $shortDescHasMarkup ? $shortDescRaw : nl2br(e($shortDescRaw));
@endphp

@section('content')
    <!-- Breadcrumb -->
    <section class="py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
                    @if ($category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('shop.index', ['category' => $category->slug ?? $category->name]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                </ol>
            </nav>
        </div>
    </section>



    <section class="product-details">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="product-details__slider">
                        <div class="product-details__slider-thumb">
                            <div class="product-details-slider swiper">
                                <div class="swiper-wrapper">
                                    @if ($productImages->count() > 0)
                                        @foreach ($productImages as $image)
                                            <div class="swiper-slide">
                                                <div class="product-details-slider-single">
                                                    <img src="{{ asset('storage/' . ($image->path ?? $image->image)) }}"
                                                        alt="{{ $product->title }}"
                                                        onerror="this.onerror=null; this.src='{{ $dummyImage }}'">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="swiper-slide">
                                            <div class="product-details-slider-single">
                                                <img src="{{ $dummyImage }}" alt="{{ $product->title }}">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="product-details-slider-gallery swiper">
                            <div class="swiper-wrapper">
                                @if ($productImages->count() > 0)
                                    @foreach ($productImages as $image)
                                        <div class="swiper-slide">
                                            <div class="sm-gallery">
                                                <img src="{{ asset('storage/' . ($image->path ?? $image->image)) }}"
                                                    alt="{{ $product->title }}"
                                                    onerror="this.onerror=null; this.src='{{ $dummyImage }}'">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <div class="sm-gallery">
                                            <img src="{{ $dummyImage }}" alt="{{ $product->title }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info (Right Column) -->
                <div class="col-12 col-md-5">
                    <div class="product-info ps-lg-4">
                        <!-- Title & Rating -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h1 class="display-6 fw-bold mb-0 text-dark" style="font-size: 28px; letter-spacing: -0.5px;">
                                {{ $product->title }}
                            </h1>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <i class="bx bxs-star text-dark small"></i>
                                <span class="fw-bold small">5.0</span>
                            </div>
                        </div>
                        <div class="mt-0 product-price">
                            @if ($purchaseMin)
                                @if ($purchaseMax && $purchaseMax != $purchaseMin)
                                    <h6>৳{{ number_format($purchaseMin, 0) }} - ৳{{ number_format($purchaseMax, 0) }}</h6>
                                @else
                                    <h6>৳{{ number_format($purchaseMin, 0) }}</h6>
                                @endif
                            @else
                                @if ($finalPrice < $originalPrice)
                                    <div class="d-flex flex-column align-items-start">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <h6 class="text-danger fw-bold mb-0">৳{{ number_format($finalPrice, 0) }}</h6>
                                            <h6 class="text-decoration-line-through text-muted mb-0" style="font-size: 0.9em;">৳{{ number_format($originalPrice, 0) }}</h6>
                                        </div>
                                        @if ($discountPercent > 0)
                                            <small class="text-success fw-600">
                                                <i class='bx bx-purchase-tag'></i> Save {{ $discountPercent }}%
                                            </small>
                                        @endif
                                    </div>
                                @else
                                    <h6>৳{{ number_format($price, 0) }}</h6>
                                @endif
                            @endif
                        </div>

                        <div class="mb-4 p-3 border rounded-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-semibold">Quick Overview</span>
                                <span class="badge bg-success-subtle text-success border border-success">In Stock</span>
                            </div>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-center gap-2 mb-1"><i class="bx bx-check text-success"></i> SKU: {{ $product->sku ?? $product->slug }}</li>
                                <li class="d-flex align-items-center gap-2 mb-1"><i class="bx bx-check text-success"></i> Category: {{ $category->name ?? 'N/A' }}</li>
                                @if($product->brand)
                                    <li class="d-flex align-items-center gap-2 mb-1"><i class="bx bx-check text-success"></i> Brand: {{ $product->brand->name }}</li>
                                @endif
                                <li class="d-flex align-items-center gap-2"><i class="bx bx-check text-success"></i> {{ $product->short_desc ? Str::limit($product->short_desc, 60) : 'Fast delivery and easy returns' }}</li>
                            </ul>
                        </div>

                        <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Variants Logic -->
                            @if ($product->variants && $product->variants->count() > 0)
                                <div id="variant-selection-message" class="mb-3 alert alert-info d-flex align-items-center"
                                    style="display: none;">
                                    <i class="bx bx-info-circle me-2"></i>
                                    <span>Please select all options to see the price and add to cart</span>
                                </div>
                                @php
                                    $axes = [];
                                    foreach ($product->variants as $v) {
                                        foreach ($v->options as $opt) {
                                            $an = $opt->attribute->name ?? 'Option';
                                            $tn = $opt->term->name ?? '';
                                            $tid = $opt->term->id ?? null;
                                            if (!isset($axes[$an])) {
                                                $axes[$an] = [];
                                            }
                                            if ($tid && !isset($axes[$an][$tid])) {
                                                $axes[$an][$tid] = $tn;
                                            }
                                        }
                                    }
                @endphp
                <div class="mb-4">
                    @foreach($axes as $attrName => $terms)
                        @php
                            $isColor = stripos($attrName, 'color') !== false || stripos($attrName, 'colour') !== false;
                            $hasSizeAxis = ($hasSizeAxis ?? false) || (stripos($attrName, 'size') !== false);
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <label class="fw-medium text-dark">Select {{ $attrName }}</label>
                                <span class="text-muted small">Guide</span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2" data-attr="{{ $attrName }}">
                                                @foreach($terms as $tid => $tname)
                                                    @if($isColor)
                                                        <!-- Color Circle -->
                                                        <button type="button" class="variant-option-color"
                                                            style="background-color: {{ strtolower($tname) }};"
                                                            data-attr="{{ $attrName }}" data-term-id="{{ $tid }}"
                                                            title="{{ $tname }}"></button>
                                                    @else
                                                        <!-- Size/Other Rectangle -->
                                                        <button type="button" class="variant-option-size px-3"
                                                            data-attr="{{ $attrName }}" data-term-id="{{ $tid }}">
                                                            {{ $tname }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($hasSizeAxis ?? false)
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-light border rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#sizeChartModal">
                                            <i class="bx bx-ruler me-1"></i> Size Guide
                                        </button>
                                    </div>
                                @endif
                            @endif

                            <div
                                class="pt-0 mt-5 mb-4 text-center btn-area1 d-flex align-items-center justify-content-start">
                                <div class="mb-0 product-quantity cart-item-single">
                                    <div class="measure">
                                        <button type="button" aria-label="decrease item" class="quantity-decrease"
                                            onclick="decreaseQty()">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" value="1"
                                            min="1" max="{{ $stockQty > 0 ? $stockQty : 99 }}"
                                            class="item-quantity-input"
                                            style="width: 40px; text-align: center; border: none; background: transparent;"
                                            readonly>
                                        <button type="button" aria-label="add item" class="quantity-increase"
                                            onclick="increaseQty()">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="p-3 w-40 border-0 action-btn-success ms-2 h-40px rounded-3"
                                    {{ !$inStock ? 'disabled' : '' }}>
                                    <i class="bx bxs-cart fs-15 me-1"></i> Add to Cart</button>
                                <button type="button"
                                    class="p-2 px-5 w-40 action-btn-success ms-2 h-40px rounded-3 buy-now-btn"
                                    {{ !$inStock ? 'disabled' : '' }}>
                                    <i class="bx bxs-bolt fs-15 me-1"></i> Buy Now</button>
                            </div>
                        </form>

                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <a href="#" class="btn btn-light border rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#quickOverviewModal"><i class="bx bx-info-circle me-1"></i> Quick Overview</a>
                            <a href="#" class="btn btn-light border rounded-3 px-3"><i class="bx bx-heart me-1"></i> Add to Wishlist</a>
                            <a href="#" class="btn btn-light border rounded-3 px-3"><i class="bx bx-git-compare me-1"></i> Compare</a>
                        </div>

                        <!-- Short Description Text -->
                        <div class="mb-5">
                            <p class="text-secondary" style="line-height: 1.6;">
                                {{ $product->short_desc ?? 'Celebrate the power and simplicity of the design. This warm, brushed fleece hoodie is made with some extra room through the shoulder.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div> 
                 <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-details" type="button" role="tab">Product Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-additional" type="button" role="tab">Additional Information</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-reviews" type="button" role="tab">Reviews</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-faq" type="button" role="tab">FAQ</button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-details" role="tabpanel">
                                    <h4 class="fw-semibold mb-3">{{ $product->title }}</h4>
                                    <p class="text-secondary">{{ $product->description ? strip_tags($product->description) : ($product->short_desc ?? '') }}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="bx bx-check text-success me-2"></i> Premium fabric</li>
                                                <li class="mb-2"><i class="bx bx-check text-success me-2"></i> Lightweight and breathable</li>
                                                <li class="mb-2"><i class="bx bx-check text-success me-2"></i> Ideal for all seasons</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="bx bx-check text-success me-2"></i> Modern slim-fit</li>
                                                <li class="mb-2"><i class="bx bx-check text-success me-2"></i> Button-down collar</li>
                                                <li class="mb-2"><i class="bx bx-check text-success me-2"></i> Easy care</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-additional" role="tabpanel">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><strong>SKU:</strong> {{ $product->sku ?? $product->slug }}</li>
                                        <li class="mb-2"><strong>Category:</strong> {{ $category->name ?? 'N/A' }}</li>
                                        @if($product->brand)
                                            <li><strong>Brand:</strong> {{ $product->brand->name }}</li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                                    <p class="text-secondary mb-0">Reviews will appear here.</p>
                                </div>
                                <div class="tab-pane fade" id="tab-faq" role="tabpanel">
                                    <p class="text-secondary mb-0">Frequently asked questions will appear here.</p>
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
                        @include('frontend.partials.product-card-template', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Size Chart Modal -->
    <div class="modal fade" id="sizeChartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Size Chart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('frontend/assets/images/size-chart.png') }}" alt="Size Chart" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Overview Modal -->
    <div class="modal fade" id="quickOverviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Overview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>{{ $product->title }}</strong>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Price:</strong> ৳{{ number_format($effectivePrice, 0) }}</li>
                        <li class="mb-2"><strong>SKU:</strong> {{ $product->sku ?? $product->slug }}</li>
                        <li class="mb-2"><strong>Category:</strong> {{ $category->name ?? 'N/A' }}</li>
                        @if($product->brand)
                            <li class="mb-2"><strong>Brand:</strong> {{ $product->brand->name }}</li>
                        @endif
                        <li class="mb-2"><strong>Status:</strong> {{ $inStock ? 'In Stock' : 'Out of Stock' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center p-0">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    @if($mainImage)
                        <img src="{{ asset('storage/' . ($mainImage->path ?? $mainImage->image)) }}" alt="{{ $product->title }}"
                            class="img-fluid rounded-3" style="max-height: 90vh;" id="zoomedImage">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="quickOverviewModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <span class="close-btn" data-bs-dismiss="modal">&times;</span>
                <div class="quick-overview-content">
                    <h4 class="mb-3">Quick Overview: {{ $product->title }}</h4>
                    <div class="product-details">
                        <p><strong>Product Name:</strong> {{ $product->title }}</p>
                        <p><strong>Price:</strong> ৳{{ number_format($finalPrice, 0) }}</p>
                        <p><strong>Description:</strong> {{ $product->short_desc }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-tab">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-tab__inner">
                        <div class="product-tab__btns">
                            <button class="product-tab__btn active" data-target="#productDetails"
                                aria-label="product details" title="product details">Product Details</button>
                            <button class="product-tab__btn" data-target="#pInformation" aria-label="product information"
                                title="product information">Additional Information</button>
                            <button class="product-tab__btn" data-target="#pReview" aria-label="product review"
                                title="product review">Reviews ({{ $product->reviews_count ?? 0 }})</button>
                            <button class="product-tab__btn" data-target="#pfaq" aria-label="product faq"
                                title="product faq">FAQ</button>
                        </div>
                        <div class="product-tab__content">
                            <div class="product-tab-content-single active" id="productDetails">
                                <div class="content">
                                    <h4>{{ $product->title }}</h4>
                                    <p class="product-description">
                                        @php
                                            $longDesc = $product->description ?? '';
                                            $renderDesc = '';

                                            if (!empty($longDesc)) {
                                                $hasMarkup = \Illuminate\Support\Str::contains($longDesc, ['<p', '<br', '<ul', '<ol', '<li', '<div', '<span']);
                                                $renderDesc = $hasMarkup ? $longDesc : nl2br(e($longDesc));
                                            } elseif (!empty($shortDescHtml)) {
                                                $renderDesc = $shortDescHtml;
                                            }
                                        @endphp

                                        @if (!empty($renderDesc))
                                            {!! $renderDesc !!}
                                        @else
                                            <p class="text-muted mb-0">No description available.</p>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="product-tab-content-single" id="pInformation">
                                <div class="content">
                                    <h4>Additional Product Information</h4>
                                    <div class="content-list cta">
                                        <ul>
                                            <li><i class="fa-solid fa-check"></i> **SKU:** {{ $product->sku ?? 'N/A' }}
                                            </li>
                                            @if ($product->brand)
                                                <li><i class="fa-solid fa-check"></i> **Brand:**
                                                    {{ $product->brand->name }}</li>
                                            @endif
                                            @if ($category)
                                                <li><i class="fa-solid fa-check"></i> **Category:** {{ $category->name }}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="product-tab-content-single" id="pReview">
                                <div class="content">
                                    @php
                                        $reviews = $product->approvedReviews()->orderByDesc('created_at')->paginate(5);
                                        $avgRating = $product->average_rating;
                                        $reviewsCount = $product->reviews_count;
                                    @endphp
                                    
                                    <div class="row">
                                        <div class="col-lg-4 mb-4">
                                            <!-- Review Summary -->
                                            <div class="review-summary p-4 bg-light rounded-3">
                                                <h4 class="mb-3">Customer Reviews</h4>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="display-4 fw-bold me-3">{{ number_format($avgRating, 1) }}</span>
                                                    <div>
                                                        <div class="stars mb-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= round($avgRating))
                                                                    <i class="fa-solid fa-star text-warning"></i>
                                                                @elseif($i - 0.5 <= $avgRating)
                                                                    <i class="fa-solid fa-star-half-alt text-warning"></i>
                                                                @else
                                                                    <i class="fa-regular fa-star text-warning"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <small class="text-muted">{{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }}</small>
                                                    </div>
                                                </div>
                                                
                                                @auth
                                                    <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#reviewFormCollapse">
                                                        <i class="bx bx-edit me-1"></i> Write a Review
                                                    </button>
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                                        <i class="bx bx-user me-1"></i> Login to Review
                                                    </a>
                                                @endauth
                                            </div>
                                            
                                            @auth
                                            <!-- Review Form -->
                                            <div class="collapse mt-3" id="reviewFormCollapse">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6 class="mb-3">Write Your Review</h6>
                                                        <form action="{{ route('product.review', $product->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="form-label">Your Rating</label>
                                                                <div class="rating-input d-flex gap-2">
                                                                    @for($i = 5; $i >= 1; $i--)
                                                                        <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" {{ $i == 5 ? 'checked' : '' }} class="d-none">
                                                                        <label for="rating{{ $i }}" class="rating-star" style="cursor: pointer; font-size: 1.5rem;">
                                                                            <i class="fa-solid fa-star text-muted"></i>
                                                                        </label>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Review Title (Optional)</label>
                                                                <input type="text" name="title" class="form-control" placeholder="Summarize your experience">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Your Review</label>
                                                                <textarea name="comment" class="form-control" rows="4" placeholder="Tell us what you liked or disliked about this product..." required minlength="10"></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-success w-100">
                                                                <i class="bx bx-send me-1"></i> Submit Review
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endauth
                                        </div>
                                        
                                        <div class="col-lg-8">
                                            <!-- Reviews List -->
                                            @if($reviews->count() > 0)
                                                <div class="reviews-list">
                                                    @foreach($reviews as $review)
                                                        <div class="review-item mb-4 pb-4 border-bottom">
                                                            <div class="d-flex align-items-start">
                                                                <div class="review-avatar me-3">
                                                                    @if($review->reviewer_image)
                                                                        <img src="{{ asset('storage/' . $review->reviewer_image) }}" 
                                                                             alt="{{ $review->reviewer_name }}"
                                                                             class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                                    @else
                                                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                                                             style="width: 50px; height: 50px; font-size: 1.2rem;">
                                                                            {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="review-content flex-grow-1">
                                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                                        <div>
                                                                            <strong>{{ $review->reviewer_name }}</strong>
                                                                            @if($review->verified_purchase)
                                                                                <span class="badge bg-success ms-2"><i class="bx bx-check"></i> Verified Purchase</span>
                                                                            @endif
                                                                            <div class="stars" style="display: flex; gap: 3px; margin-top: 6px;">
                                                                                @for($i = 1; $i <= 5; $i++)
                                                                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 0.9rem; flex-shrink: 0;"></i>
                                                                                @endfor
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                                    </div>
                                                                    @if($review->title)
                                                                        <h6 class="mb-2">"{{ $review->title }}"</h6>
                                                                    @endif
                                                                    <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                @if($reviews->hasPages())
                                                    <div class="mt-4">
                                                        {{ $reviews->links() }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-5">
                                                    <i class="bx bx-message-square-x fs-1 text-muted"></i>
                                                    <p class="mt-3 text-muted">No reviews yet. Be the first to review this product!</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-tab-content-single" id="pfaq">
                                <div class="content">
                                    <h4 class="mb-4">Frequently Asked Questions</h4>
                                    <div class="accordion" id="faqAccordion">
                                        <!-- FAQ 1 -->
                                        <div class="accordion-item mb-3 border rounded">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                                    <strong>Q1: What age group are these backpacks designed for?</strong>
                                                </button>
                                            </h2>
                                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    <p class="mb-0">These versatile bags cater to various ages, featuring ergonomic straps and playful designs like Frozen for children, alongside sophisticated calligraphy and sports themes suitable for students and young adults.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FAQ 2 -->
                                        <div class="accordion-item mb-3 border rounded">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                                    <strong>Q2: Are these bags water-resistant for outdoor use?</strong>
                                                </button>
                                            </h2>
                                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    <p class="mb-0">Yes, the backpacks are crafted from durable, high-quality synthetic fabrics designed to repel light moisture, ensuring your books, electronics, and personal items stay dry during daily commutes or school activities.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FAQ 3 -->
                                        <div class="accordion-item mb-3 border rounded">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                                    <strong>Q3: How many compartments do these backpacks typically have?</strong>
                                                </button>
                                            </h2>
                                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    <p class="mb-0">Most models feature a spacious main compartment for larger items, a dedicated front pocket for quick-access essentials, and side mesh pockets perfect for carrying water bottles or umbrellas conveniently.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        :root {
            --pd-primary: var(--home-primary, #0496ff);
            --pd-secondary: var(--home-secondary, #1a1a2e);
        }

        .product-tab__btns {
            background: color-mix(in srgb, var(--pd-secondary) 8%, #ffffff 92%);
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            gap: 12px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-start;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .product-tab__btn {
            border: 1px solid color-mix(in srgb, var(--pd-secondary) 30%, #000 5%);
            color: var(--pd-secondary);
            background: #fff;
            transition: all 0.2s ease;
            padding: 12px 18px;
            border-radius: 999px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 165px;
            min-height: 46px;
            text-align: center;
            font-size: 15px;
            line-height: 1.3;
            text-decoration: none;
        }

        .product-tab__btn.active,
        .product-tab__btn:focus {
            background: var(--pd-primary);
            border-color: var(--pd-primary);
            color: #fff !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .product-tab__btn:hover {
            background: color-mix(in srgb, var(--pd-primary) 88%, #000 12%);
            border-color: color-mix(in srgb, var(--pd-primary) 88%, #000 12%);
            color: #fff;
        }

        .product-tab__btn:not(.active):not(:focus) {
            background: #fff;
            color: var(--pd-secondary);
        }

        .product-tab__content {
            background: #fff;
            border: 1px solid color-mix(in srgb, var(--pd-secondary) 12%, #000 3%);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            margin-top: 12px;
        }

        .product-tab__content .content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .product-tab-content-single {
            display: none;
        }

        .product-tab-content-single.active {
            display: block;
        }

        .product-description,
        .product-description * {
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .product-description p,
        .product-description li {
            margin-bottom: 0.75rem;
            line-height: 1.7;
            color: #1f2937;
            font-size: 15px;
            font-weight: 500;
        }

        .product-description ul,
        .product-description ol {
            padding-left: 1.25rem;
            margin-bottom: 0.75rem;
        }
    </style>
@endpush

@push('scripts')
    @php
        $variantsData =
            $product->variants && $product->variants->count() > 0
                ? $product->variants
                    ->map(function ($v) {
                        $base = $v->price;
                        if ($base === null || $base <= 0) {
                            $purchaseSell = \Illuminate\Support\Facades\DB::table('purchase_items')
                                ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                                ->where('purchase_items.variant_id', $v->id)
                                ->where('purchases.status', 'received')
                                ->orderByDesc('purchases.purchase_date')
                                ->value('purchase_items.sell_price');
                            $base = $purchaseSell ?? ($v->product->sale_price ?? $v->product->price);
                        }
                        // Get stock quantity for this variant
                        $stock = $v->stock_quantity ?? 0;
                        $inStock = $stock > 0 || ($product->allow_backorder ?? false);

                        return [
                            'id' => $v->id,
                            'label' => $v->combination_key ?? ($v->sku ?? ''),
                            'price' => $base,
                            'stock' => $stock,
                            'inStock' => $inStock,
                            'sku' => $v->sku ?? '',
                            'pairs' => $v->options
                                ->map(function ($opt) {
                                    return [
                                        'attr' => optional($opt->attribute)->name ?? 'Option',
                                        'term_id' => optional($opt->term)->id,
                                    ];
                                })
                                ->toArray(),
                        ];
                    })
                    ->toArray()
                : [];
    @endphp
    <script>
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
            var hasVariants = @json($product->variants && $product->variants->count() > 0);
            if (hasVariants) {
                var variantId = document.getElementById('variant_id')?.value;
                if (!variantId) {
                    alert('Please select all product options before proceeding');
                    return;
                }
            }
            var form = document.getElementById('add-to-cart-form');
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'buy_now';
            input.value = '1';
            form.appendChild(input);
            form.submit();
        });

        // Add to Cart Form Validation
        document.getElementById('add-to-cart-form')?.addEventListener('submit', function(e) {
            var hasVariants = @json($product->variants && $product->variants->count() > 0);
            if (hasVariants) {
                var variantId = document.getElementById('variant_id')?.value;
                if (!variantId) {
                    e.preventDefault();
                    alert('Please select all product options before adding to cart');
                    return false;
                }
            }
        });

        document.getElementById('variant_id')?.addEventListener('change', function() {
            var t = this.options[this.selectedIndex]?.text || '';
            var hidden = document.getElementById('variant_name');
            if (hidden) hidden.value = t;
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Init Variant Selection
            (function initVariantChips() {
                var chips = document.querySelectorAll('.variant-chip-btn');
                if (!chips.length) return;

                var selected = {};
                var variants = @json($variantsData);

                function updateVariantInput() {
                    var matchId = null,
                        matchLabel = '',
                        matchPrice = null,
                        matchVariant = null;
                    variants.forEach(function(v) {
                        var ok = true;
                        for (var a in selected) {
                            var wantTid = selected[a];
                            var found = v.pairs.find(p => p.attr == a && p.term_id == wantTid);
                            if (!found) {
                                ok = false;
                                break;
                            }
                        }
                        if (ok && Object.keys(selected).length === v.pairs.length) {
                            matchId = v.id;
                            matchLabel = v.label;
                            matchPrice = v.price;
                            matchVariant = v;
                        }
                    });

                    var vidInput = document.getElementById('variant_id');
                    var vnameInput = document.getElementById('variant_name');
                    var vpriceInput = document.getElementById('variant_price');
                    var messageEl = document.getElementById('variant-selection-message');
                    var stockEl = document.getElementById('variant-stock-info');

                    if (vidInput) vidInput.value = matchId || '';
                    if (vnameInput) vnameInput.value = matchLabel || '';
                    if (vpriceInput) vpriceInput.value = matchPrice || '';

                    // Show/hide selection message
                    if (messageEl) {
                        if (matchId) {
                            messageEl.style.display = 'none';
                        } else {
                            messageEl.style.display = 'flex';
                        }
                    }

                    // Update displayed price
                    if (matchPrice && matchPrice > 0) {
                        var priceElement = document.querySelector('.product-price h6');
                        if (priceElement) {
                            priceElement.innerHTML = '৳' + Number(matchPrice).toLocaleString('en-IN', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        }
                    }

                    // Update stock information
                    if (stockEl && matchVariant) {
                        var skuEl = document.getElementById('variant-sku');
                        var stockQtyEl = document.getElementById('stock-quantity');
                        if (skuEl) skuEl.textContent = matchLabel || '-';

                        if (stockQtyEl) {
                            if (matchVariant.inStock) {
                                stockQtyEl.textContent = '✓ ' + matchVariant.stock + ' in stock';
                                stockQtyEl.classList.remove('out-of-stock');
                            } else {
                                stockQtyEl.textContent = '✕ Out of Stock';
                                stockQtyEl.classList.add('out-of-stock');
                            }
                        }
                        stockEl.classList.remove('d-none');
                    } else if (stockEl) {
                        stockEl.classList.add('d-none');
                    }

                    // Update selected value display for each attribute
                    for (var attr in selected) {
                        var displays = document.querySelectorAll('[data-attr="' + attr + '"]');
                        displays.forEach(d => {
                            if (d.classList.contains('variant-selected-value')) {
                                var termName = document.querySelector('.variant-chip-btn[data-attr="' +
                                    attr + '"][data-term-id="' + selected[attr] +
                                    '"][data-term-name]')?.getAttribute('data-term-name');
                                if (termName) d.textContent = termName;
                            }
                        });
                    }
                }

                // Initialize - show message on load if variants exist
                var messageEl = document.getElementById('variant-selection-message');
                if (messageEl && variants.length > 0) {
                    messageEl.style.display = 'flex';
                }

                // Check which options are available
                function updateAvailability() {
                    chips.forEach(function(chip) {
                        var attr = chip.getAttribute('data-attr');
                        var tid = chip.getAttribute('data-term-id');

                        // Build current selection with this option
                        var testSelected = Object.assign({}, selected);
                        testSelected[attr] = tid;

                        // Check if any variant matches this combination
                        var isAvailable = false;
                        variants.forEach(function(v) {
                            // Skip variants with 0 or no stock (unless backorder allowed/inStock flag)
                            if (v.inStock === false || (v.inStock === undefined && v.stock <= 0)) return;
                            var matches = true;
                            for (var a in testSelected) {
                                var found = v.pairs.find(p => p.attr == a && p.term_id ==
                                    testSelected[a]);
                                if (!found) {
                                    matches = false;
                                    break;
                                }
                            }
                            // If all selected options match and this option is part of the variant
                            var hasThisOption = v.pairs.find(p => p.attr == attr && p.term_id ==
                                tid);
                            if (matches && hasThisOption) {
                                isAvailable = true;
                            }
                        });

                        // Update button state
                        var wrapper = chip.closest('.variant-chip-wrapper');
                        if (wrapper) {
                            var badge = wrapper.querySelector('.availability-badge');
                            if (!isAvailable) {
                                chip.classList.add('disabled');
                                if (badge) {
                                    badge.style.display = 'inline-block';
                                    badge.classList.add('out-of-stock');
                                    badge.classList.remove('in-stock');
                                    // badge.textContent = '✕';
                                }
                            } else {
                                chip.classList.remove('disabled');
                                if (badge) {
                                    badge.classList.remove('out-of-stock');
                                }
                            }
                        }
                    });
                }

                // Initial availability check
                updateAvailability();

                chips.forEach(function(chip) {
                    chip.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Check if clicking the deselect icon
                        if (e.target.classList.contains('deselect-icon') || e.target.closest(
                                '.deselect-icon') ||
                            e.target.classList.contains('deselect-icon-color') || e.target
                            .closest('.deselect-icon-color')) {
                            var attr = this.getAttribute('data-attr');
                            this.classList.remove('active');
                            delete selected[attr];
                            updateVariantInput();
                            updateAvailability();
                            return;
                        }

                        // Don't allow clicking disabled chips
                        if (this.classList.contains('disabled')) {
                            return;
                        }

                        var attr = this.getAttribute('data-attr');
                        var tid = this.getAttribute('data-term-id');

                        // Find the container (variant-colors-wrapper or variant-options-grid)
                        var container = this.closest('.variant-option-group');
                        if (container) {
                            // Deselect others in same attribute
                            var siblings = container.querySelectorAll(
                                '.variant-chip-btn[data-attr="' + attr + '"]');
                            siblings.forEach(function(s) {
                                s.classList.remove('active');
                            });

                            // Select this
                            this.classList.add('active');
                            selected[attr] = tid;

                            updateVariantInput();
                            updateAvailability();
                        }
                    });
                });
            })();
        });
    </script>


    <script>
        // Rating input interaction
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInputs = document.querySelectorAll('.rating-input input[type="radio"]');
            const ratingLabels = document.querySelectorAll('.rating-input .rating-star');
            
            function updateStars() {
                const checked = document.querySelector('.rating-input input:checked');
                const checkedValue = checked ? parseInt(checked.value) : 0;
                
                ratingLabels.forEach((label, index) => {
                    const starValue = 5 - index;
                    const icon = label.querySelector('i');
                    if (starValue <= checkedValue) {
                        icon.classList.remove('text-muted');
                        icon.classList.add('text-warning');
                    } else {
                        icon.classList.add('text-muted');
                        icon.classList.remove('text-warning');
                    }
                });
            }
            
            ratingInputs.forEach(input => {
                input.addEventListener('change', updateStars);
            });
            
            // Initialize on page load
            updateStars();
        });

        // Product tabs interaction
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.product-tab__btn');
            const tabPanels = document.querySelectorAll('.product-tab-content-single');

            if (!tabButtons.length || !tabPanels.length) return;

            tabButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const targetSelector = btn.getAttribute('data-target');
                    if (!targetSelector) return;

                    const targetPanel = document.querySelector(targetSelector);
                    if (!targetPanel) return;

                    tabButtons.forEach((b) => b.classList.remove('active'));
                    tabPanels.forEach((p) => p.classList.remove('active'));

                    btn.classList.add('active');
                    targetPanel.classList.add('active');
                });
            });
        });
    </script>
@endpush
