@extends('layouts.frontend')

@section('title', ($product->title ?? 'Product Details') . ' - GrowUp E-Commerce')

@php
    // Get product images
    $productImages = collect();
    if ($product->images && $product->images->count() > 0) {
        $productImages = $product->images->sortByDesc('is_cover');
    }
    $mainImage = $productImages->first();

    // Fallback dummy image
    $dummyImage = asset('frontend/assets/images/shop/KHPP-SA21 - 1.png');

    // Get price
    $price = $product->price ?? 0;
    $salePrice = $product->sale_price ?? null;
    $isOnSale = $salePrice && $salePrice < $price;
    $discountPercent = $isOnSale && $price > 0 ? round((($price - $salePrice) / $price) * 100) : 0;
    $effectivePrice = $isOnSale ? $salePrice : $price;

    // Get stock
    $stockQty = $product->stock_quantity ?? 0;
    $inStock = $stockQty > 0 || ($product->allow_backorder ?? false);

    // Get category
    $category = $product->categories && $product->categories->count() > 0
        ? $product->categories->first()
        : null;
@endphp

@section('content')
    <!-- Breadcrumb Section -->
    <section class="py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
                    @if($category)
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

    <!-- Product Details Section -->
    <style>
        .variant-option-color {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #e5e5e5;
            padding: 0;
            position: relative;
            cursor: pointer;
            transition: all 0.2s;
        }
        .variant-option-color:hover {
            transform: scale(1.1);
        }
        .variant-option-color.active {
            border: 1px solid #fff;
            box-shadow: 0 0 0 1px #000;
        }
        .variant-option-size {
            min-width: 60px;
            height: 40px;
            border: 1px solid #e5e5e5;
            background: #fff;
            color: #000;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }
        .variant-option-size:hover {
            border-color: #000;
        }
        .variant-option-size.active {
            border-color: #000;
            background: #fff;
            box-shadow: 0 0 0 1px #000;
        }
        .nike-qty-input {
            border: 1px solid #e5e5e5;
            border-radius: 30px;
            padding: 5px 10px;
            display: inline-flex;
            align-items: center;
            width: 140px;
            justify-content: space-between;
        }
        .nike-qty-input button {
            border: none;
            background: transparent;
            font-size: 18px;
            color: #000;
            padding: 0 10px;
        }
        .nike-qty-input input {
            border: none;
            text-align: center;
            width: 40px;
            background: transparent;
            font-weight: 500;
            font-size: 16px;
        }
        .btn-nike-outline {
            border: 1px solid #cacaca;
            background: #fff;
            color: #000;
            border-radius: 30px;
            padding: 18px;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.2s;
        }
        .btn-nike-outline:hover {
            border-color: #000;
        }
        .btn-nike-solid {
            background: #000;
            color: #fff;
            border-radius: 30px;
            padding: 18px;
            font-weight: 500;
            font-size: 16px;
            border: none;
            transition: all 0.2s;
        }
        .btn-nike-solid:hover {
            background: #333;
            color: #fff;
        }
        .product-accordion .accordion-item {
            border: none;
            border-top: 1px solid #e5e5e5;
        }
        .product-accordion .accordion-button {
            background: transparent;
            padding: 20px 0;
            font-size: 18px;
            font-weight: 500;
            color: #000;
            box-shadow: none;
        }
        .product-accordion .accordion-button:not(.collapsed) {
            color: #000;
            background: transparent;
        }
        .product-accordion .accordion-body {
            padding: 0 0 20px 0;
            color: #757575;
        }
        .thumbnail-scroll::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
    </style>

    <section class="product-details py-5">
        <div class="container">
            <div class="row gx-5">
                <!-- Product Images (Left Column) -->
                <div class="col-12 col-md-7 mb-5 mb-md-0">
                    <div class="d-flex flex-column-reverse flex-md-row gap-3 position-sticky" style="top: 2rem;">
                        <!-- Thumbnails (Vertical on Desktop, Horizontal on Mobile) -->
                        <div class="thumbnail-list d-flex flex-md-column gap-3 overflow-auto thumbnail-scroll" 
                             style="max-height: 80vh;">
                            @if($productImages->count() > 0)
                                @foreach($productImages as $index => $image)
                                    <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}"
                                        style="width: 60px; height: 60px; min-width: 60px; cursor: pointer; border-radius: 8px; overflow: hidden; opacity: {{ $index == 0 ? '1' : '0.6' }}; transition: opacity 0.2s;"
                                        onmouseover="changeMainImage(this, '{{ asset('storage/' . ($image->path ?? $image->image)) }}')"
                                        onclick="changeMainImage(this, '{{ asset('storage/' . ($image->path ?? $image->image)) }}')">
                                        <img src="{{ asset('storage/' . ($image->path ?? $image->image)) }}"
                                            alt="{{ $product->title }}" class="img-fluid w-100 h-100" style="object-fit: cover; border-radius: 8px;"
                                            onerror="this.onerror=null; this.src='{{ $dummyImage }}'">
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Main Image -->
                        <div class="main-image-container flex-grow-1 position-relative bg-light rounded-4 overflow-hidden" style="min-height: 500px;">
                            <img src="{{ asset('storage/' . ($mainImage->path ?? $mainImage->image)) }}"
                                alt="{{ $product->title }}" class="img-fluid w-100 h-100 position-absolute top-0 start-0"
                                id="mainProductImage" style="object-fit: contain;"
                                onerror="this.onerror=null; this.src='{{ $dummyImage }}';">
                            
                            <!-- Navigation Arrows (Optional visual flair) -->
                            <button class="btn btn-light rounded-circle shadow-sm position-absolute top-50 start-0 translate-middle-y ms-3 d-none d-md-block" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-light rounded-circle shadow-sm position-absolute top-50 end-0 translate-middle-y me-3 d-none d-md-block" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
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

                        <!-- Brand/Category Subtitle -->
                        <div class="mb-3">
                            @if($product->brand)
                                <span class="text-muted small fw-medium">{{ $product->brand->name }}</span>
                            @endif
                            @if($product->brand && $category) <span class="text-muted small">•</span> @endif
                            @if($category)
                                <span class="text-muted small fw-medium">{{ $category->name }}</span>
                            @endif
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            @if($isOnSale)
                                <span class="fs-5 text-muted text-decoration-line-through me-2">৳{{ number_format($price, 0) }}</span>
                                <span class="fs-4 fw-medium text-dark">৳{{ number_format($salePrice, 0) }}</span>
                            @else
                                <span class="fs-4 fw-medium text-dark">৳{{ number_format($price, 0) }}</span>
                            @endif
                            <div class="text-muted small mt-1">
                                Pay in 4 interest-free installments for orders over ৳5000.
                            </div>
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

                            <!-- Variants -->
                            @if($product->variants && $product->variants->count() > 0)
                                @php
                                    $axes = [];
                                    foreach ($product->variants as $v) {
                                        foreach ($v->options as $opt) {
                                            $an = $opt->attribute->name ?? 'Option';
                                            $tn = $opt->term->name ?? '';
                                            $tid = $opt->term->id ?? null;
                                            if (!isset($axes[$an])) $axes[$an] = [];
                                            if ($tid && !isset($axes[$an][$tid])) $axes[$an][$tid] = $tn;
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
                                    <input type="hidden" name="variant_id" id="variant_id" value="">
                                    <input type="hidden" name="variant" id="variant_name" value="">
                                </div>
                                @if($hasSizeAxis ?? false)
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-light border rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#sizeChartModal">
                                            <i class="bx bx-ruler me-1"></i> Size Guide
                                        </button>
                                    </div>
                                @endif
                            @endif

                            <!-- Quantity -->
                            <div class="mb-4">
                                <label class="fw-medium text-dark mb-2 d-block">Quantity</label>
                                <div class="nike-qty-input">
                                    <button type="button" onclick="decreaseQty()">−</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $stockQty > 0 ? $stockQty : 99 }}" readonly>
                                    <button type="button" onclick="increaseQty()">+</button>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-nike-outline w-100" {{ !$inStock ? 'disabled' : '' }}>
                                        Add to Cart
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-nike-solid w-100 buy-now-btn" {{ !$inStock ? 'disabled' : '' }}>
                                        Buy It Now
                                    </button>
                                </div>
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
            transition: color 0.2s;
        }

        .rating-stars label:hover,
        .rating-stars label:hover~label,
        .rating-stars input:checked~label {
            color: #ffc107;
        }

        .thumbnail-item {
            transition: all 0.3s ease;
        }

        .thumbnail-item:hover {
            border-color: #0496ff !important;
            transform: translateY(-2px);
        }

        .thumbnail-item.active {
            border-color: #0496ff !important;
        }

        .product-title {
            line-height: 1.3;
        }

        .nav-tabs .nav-link {
            color: #666;
            border: none;
            padding: 15px 25px;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #0496ff;
            border-bottom: 3px solid #0496ff;
            background: transparent;
        }

        .nav-tabs .nav-link:hover {
            color: #0496ff;
            border-color: transparent;
        }

        .variant-chip {
            min-width: 44px;
            border-radius: 8px;
        }
        .variant-chip.active {
            background-color: #0496ff;
            border-color: #0496ff;
            color: #fff;
        }

        .quantity-selector .btn {
            z-index: 1;
        }

        .quantity-selector .input-group {
            width: 160px !important;
        }
        .quantity-selector .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
            height: 40px;
        }
        .quantity-selector .btn {
            height: 40px;
            width: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .delivery-info {
            position: relative;
            z-index: 1;
        }
    </style>
@endpush

@push('scripts')
    @php
        $variantsData = ($product->variants && $product->variants->count() > 0)
            ? $product->variants->map(function($v){
                return [
                    'id' => $v->id,
                    'label' => $v->combination_key ?? ($v->sku ?? ''),
                    'pairs' => $v->options->map(function($opt){
                        return [
                            'attr' => optional($opt->attribute)->name ?? 'Option',
                            'term_id' => optional($opt->term)->id,
                        ];
                    })->toArray(),
                ];
            })->toArray()
            : [];
    @endphp
    <script>
        function changeMainImage(element, src) {
            document.getElementById('mainProductImage').src = src;
            document.getElementById('zoomedImage').src = src;
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
        document.querySelector('.buy-now-btn')?.addEventListener('click', function () {
            var form = document.getElementById('add-to-cart-form');
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'buy_now';
            input.value = '1';
            form.appendChild(input);
            form.submit();
        });

        document.getElementById('variant_id')?.addEventListener('change', function() {
            var t = this.options[this.selectedIndex]?.text || '';
            var hidden = document.getElementById('variant_name');
            if (hidden) hidden.value = t;
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            // Init Variant Selection
            (function initVariantChips(){
                var chips = document.querySelectorAll('.variant-option-color, .variant-option-size');
                if (!chips.length) return;
                
                var selected = {};
                var variants = @json($variantsData);
                
                function updateVariantInput() {
                    var matchId = null, matchLabel = '';
                    // Find variant that matches ALL selected attributes
                    // If an attribute is not selected yet, we can't match a specific variant uniquely 
                    // unless we assume defaults. But here we have pre-selection.
                    
                    variants.forEach(function(v){
                        var ok = true;
                        for (var a in selected) {
                            var wantTid = selected[a];
                            // Check if this variant has this attribute-term pair
                            if (!v.pairs.some(function(p){ return p.attr === a && String(p.term_id) === String(wantTid); })) {
                                ok = false; break;
                            }
                        }
                        // Also check if variant has ALL the attributes we expect (optional but good for strictness)
                        // For now, we just check if the selected ones match. 
                        // Since we pre-select all axes, this finds the unique variant.
                        if (ok) { matchId = v.id; matchLabel = v.label; }
                    });

                    var vInput = document.getElementById('variant_id');
                    var nInput = document.getElementById('variant_name');
                    if (vInput) vInput.value = matchId || '';
                    if (nInput) nInput.value = matchLabel || '';
                }

                chips.forEach(function(chip){
                    chip.addEventListener('click', function(){
                        var attr = this.getAttribute('data-attr');
                        var tid = this.getAttribute('data-term-id');
                        
                        // Update UI: Deselect siblings, select this
                        var siblings = document.querySelectorAll('.variant-option-color[data-attr="'+attr+'"], .variant-option-size[data-attr="'+attr+'"]');
                        siblings.forEach(function(sib){
                            sib.classList.remove('active');
                        });
                        this.classList.add('active');
                        
                        // Update State
                        selected[attr] = tid;
                        updateVariantInput();
                    });
                });

                // Pre-select first option for each attribute
                var groups = document.querySelectorAll('.d-flex.flex-wrap[data-attr]'); 
                groups.forEach(function(group){
                    var first = group.querySelector('.variant-option-color, .variant-option-size');
                    if (first) {
                        first.click();
                    }
                });
            })();
        });
    </script>
@endpush
