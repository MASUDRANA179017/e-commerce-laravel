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
    <section class="product-details py-5">
        <div class="container">
            <div class="row">
                <!-- Product Images -->
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="product-images">
                        <!-- Main Image -->
                        <div class="main-image mb-3 position-relative overflow-hidden rounded-4 bg-light d-flex align-items-center justify-content-center"
                            style="aspect-ratio: 1/1; max-height: 500px;">
                            @if($mainImage)
                                <img src="{{ asset('storage/' . ($mainImage->path ?? $mainImage->image)) }}"
                                    alt="{{ $product->title }}" class="img-fluid w-100" id="mainProductImage"
                                    style="max-height: 500px; object-fit: contain;"
                                    onerror="this.onerror=null; this.src='{{ $dummyImage }}';">
                            @else
                                <img src="{{ $dummyImage }}" alt="{{ $product->title }}" class="img-fluid w-100"
                                    id="mainProductImage" style="max-height: 500px; object-fit: contain;">
                            @endif

                            <!-- Badges -->
                            <div class="position-absolute top-0 start-0 p-3 d-flex flex-column gap-2">
                                @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                                    <span class="badge bg-primary px-3 py-2">New</span>
                                @endif
                                @if($isOnSale)
                                    <span class="badge bg-danger px-3 py-2">-{{ $discountPercent }}% OFF</span>
                                @endif
                                @if($product->featured)
                                    <span class="badge bg-warning text-dark px-3 py-2">Featured</span>
                                @endif
                            </div>

                            <!-- Zoom Icon -->
                            <button class="btn btn-light btn-sm rounded-circle position-absolute bottom-0 end-0 m-3 shadow"
                                data-bs-toggle="modal" data-bs-target="#imageZoomModal">
                                <i class="fa-solid fa-search-plus"></i>
                            </button>
                        </div>

                        <!-- Thumbnail Gallery -->
                        @if($productImages->count() > 1)
                            <div class="thumbnail-gallery d-flex gap-2 flex-wrap justify-content-center">
                                @foreach($productImages as $index => $image)
                                    <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}"
                                        style="width: 80px; height: 80px; cursor: pointer; border: 2px solid {{ $index == 0 ? '#0496ff' : '#eee' }}; border-radius: 10px; overflow: hidden; transition: all 0.3s;">
                                        <img src="{{ asset('storage/' . ($image->path ?? $image->image)) }}"
                                            alt="{{ $product->title }}" class="img-fluid w-100 h-100" style="object-fit: cover;"
                                            onclick="changeMainImage(this, '{{ asset('storage/' . ($image->path ?? $image->image)) }}')"
                                            onerror="this.onerror=null; this.src='{{ $dummyImage }}'">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-12 col-lg-6">
                    <div class="product-info ps-lg-4" data-aos="fade-up">
                        <!-- Brand -->
                        @if($product->brand)
                            <a href="{{ route('shop.index', ['brand' => $product->brand->slug ?? $product->brand->name]) }}"
                                class="text-primary text-decoration-none fw-medium mb-2 d-inline-block">
                                {{ $product->brand->name }}
                            </a>
                        @endif

                        <!-- Product Title -->
                        <h1 class="product-title mb-3" style="font-size: 32px; font-weight: 700; color: #1a1a2e;">
                            {{ $product->title }}
                        </h1>

                        <!-- Rating & Stock -->
                        <div class="product-rating d-flex align-items-center flex-wrap gap-3 mb-3">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= 4 ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="text-muted ms-2">(0 Reviews)</span>
                            </div>
                            <span class="border-start ps-3">
                                @if($inStock)
                                    <i class="fa-solid fa-check-circle text-success me-1"></i>
                                    <span class="text-success fw-medium">In Stock</span>
                                    @if($stockQty > 0 && $stockQty <= 10)
                                        <small class="text-warning ms-1">(Only {{ $stockQty }} left)</small>
                                    @endif
                                @else
                                    <i class="fa-solid fa-times-circle text-danger me-1"></i>
                                    <span class="text-danger fw-medium">Out of Stock</span>
                                @endif
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="product-price mb-4 p-3 bg-light rounded-3">
                            @if($isOnSale)
                                <span class="current-price text-danger" style="font-size: 36px; font-weight: 700;">
                                    ৳{{ number_format($salePrice, 0) }}
                                </span>
                                <span class="original-price text-muted text-decoration-line-through ms-2"
                                    style="font-size: 22px;">
                                    ৳{{ number_format($price, 0) }}
                                </span>
                                <span class="badge bg-danger ms-2 fs-6">
                                    Save ৳{{ number_format($price - $salePrice, 0) }}
                                </span>
                            @else
                                <span class="current-price" style="font-size: 36px; font-weight: 700; color: #0496ff;">
                                    ৳{{ number_format($price, 0) }}
                                </span>
                            @endif
                        </div>

                        <!-- Short Description -->
                        @if($product->short_desc)
                            <div class="product-description mb-4">
                                <p class="text-muted mb-0">{{ $product->short_desc }}</p>
                            </div>
                        @endif

                        <!-- Product Meta -->
                        <div class="product-meta mb-4">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td class="text-muted" width="120"><i class="fa-solid fa-barcode me-2"></i>SKU</td>
                                    <td class="fw-medium">{{ $product->sku ?? $product->slug }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><i class="fa-solid fa-folder me-2"></i>Category</td>
                                    <td>
                                        @if($category)
                                            <a href="{{ route('shop.index', ['category' => $category->slug ?? $category->name]) }}"
                                                class="text-primary">
                                                {{ $category->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Uncategorized</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($product->brand)
                                    <tr>
                                        <td class="text-muted"><i class="fa-solid fa-tag me-2"></i>Brand</td>
                                        <td>
                                            <a href="{{ route('shop.index', ['brand' => $product->brand->slug ?? $product->brand->name]) }}"
                                                class="text-primary">
                                                {{ $product->brand->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted"><i class="fa-solid fa-box me-2"></i>Stock</td>
                                    <td>
                                        @if($stockQty > 0)
                                            <span class="text-success fw-medium">{{ $stockQty }} available</span>
                                        @elseif($product->allow_backorder)
                                            <span class="text-warning">Available on backorder</span>
                                        @else
                                            <span class="text-danger">Out of stock</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

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
                                <label class="mb-2 fw-bold">Choose Options:</label>
                                <div class="d-flex flex-column gap-3">
                                    @foreach($axes as $attrName => $terms)
                                        <div>
                                            <div class="small text-muted mb-1">{{ $attrName }}</div>
                                            <div class="d-flex flex-wrap gap-2" data-attr="{{ $attrName }}">
                                                @foreach($terms as $tid => $tname)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary variant-chip"
                                                        data-attr="{{ $attrName }}" data-term-id="{{ $tid }}">{{ $tname }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="variant_id" id="variant_id" value="">
                                <input type="hidden" name="variant" id="variant_name" value="">
                            </div>
                            @endif

                            <!-- Quantity Selector -->
                            <div class="quantity-selector d-flex align-items-center gap-3 mb-4">
                                <label class="mb-0 fw-bold">Quantity:</label>
                                <div class="input-group" style="width: 150px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity"
                                        class="form-control text-center fw-bold" value="1" min="1"
                                        max="{{ $stockQty > 0 ? $stockQty : 99 }}" readonly>
                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons d-flex flex-wrap gap-3 mb-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 flex-grow-1" {{ !$inStock ? 'disabled' : '' }}
                                    style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border: none;">
                                    <i class="fa-solid fa-cart-plus me-2"></i> Add to Cart
                                </button>
                                <button type="button" class="btn btn-success btn-lg px-4 buy-now-btn" {{ !$inStock ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-bolt me-2"></i> Buy Now
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-lg add-to-wishlist"
                                    data-product-id="{{ $product->id }}">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Delivery Info -->
                        <div class="delivery-info p-3 bg-light rounded-3 mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-truck text-primary me-3 fs-5"></i>
                                <div>
                                    <strong>Free Delivery</strong>
                                    <small class="d-block text-muted">On orders over ৳5,000</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-rotate-left text-primary me-3 fs-5"></i>
                                <div>
                                    <strong>Easy Returns</strong>
                                    <small class="d-block text-muted">30 days return policy</small>
                                </div>
                            </div>
                        </div>

                        <!-- Social Share -->
                        <div class="social-share pt-3 border-top">
                            <strong class="me-3">Share:</strong>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->title) }}"
                                target="_blank" class="btn btn-sm btn-outline-info me-2">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($product->title . ' - ৳' . number_format($effectivePrice, 0) . ' ' . request()->url()) }}"
                                target="_blank" class="btn btn-sm btn-outline-success me-2">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($product->title) }}&body={{ urlencode('Check out this product: ' . request()->url()) }}"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-envelope"></i>
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
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white rounded-top-4">
                    <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab">
                                <i class="fa-solid fa-file-lines me-2"></i>Description
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specifications-tab" data-bs-toggle="tab"
                                data-bs-target="#specifications" type="button" role="tab">
                                <i class="fa-solid fa-list-check me-2"></i>Specifications
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab">
                                <i class="fa-solid fa-star me-2"></i>Reviews (0)
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="productTabsContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="product-description">
                                @if($product->short_desc)
                                    <p class="lead">{{ $product->short_desc }}</p>
                                @endif
                                @if($product->description ?? false)
                                    {!! $product->description !!}
                                @else
                                    <p class="text-muted">No detailed description available for this product.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Specifications Tab -->
                        <div class="tab-pane fade" id="specifications" role="tabpanel">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th width="200">SKU</th>
                                        <td>{{ $product->sku ?? $product->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Name</th>
                                        <td>{{ $product->title }}</td>
                                    </tr>
                                    @if($category)
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $category->name }}</td>
                                        </tr>
                                    @endif
                                    @if($product->brand)
                                        <tr>
                                            <th>Brand</th>
                                            <td>{{ $product->brand->name }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Status</th>
                                        <td><span
                                                class="badge bg-{{ $product->status == 'Active' ? 'success' : 'secondary' }}">{{ $product->status }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Stock</th>
                                        <td>{{ $stockQty }} units</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <p class="text-muted">No reviews yet. Be the first to review this product!</p>

                            @auth
                                <div class="write-review mt-4 pt-4 border-top">
                                    <h5 class="mb-3"><i class="fa-solid fa-pen me-2"></i>Write a Review</h5>
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
                                            <textarea name="comment" class="form-control" rows="4" required
                                                placeholder="Share your experience with this product..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-paper-plane me-2"></i>Submit Review
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="mt-4 pt-4 border-top text-center">
                                    <p class="mb-3">Please login to write a review.</p>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-sign-in-alt me-2"></i>Login to Review
                                    </a>
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
                            @include('frontend.partials.product-card-template', ['product' => $relatedProduct])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

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
        
        (function initVariantChips(){
            var chips = document.querySelectorAll('.variant-chip');
            if (!chips.length) return;
            var selected = {};
            chips.forEach(function(chip){
                chip.addEventListener('click', function(){
                    var attr = this.dataset.attr;
                    var tid = this.dataset.termId;
                    // toggle selection per attr
                    document.querySelectorAll('.variant-chip[data-attr="' + attr + '"]').forEach(function(c){
                        c.classList.remove('active');
                        c.classList.remove('btn-primary');
                        c.classList.add('btn-outline-secondary');
                    });
                    this.classList.add('active');
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-primary');
                    selected[attr] = tid;
                    // find matching variant by selected terms
                    var variants = @json($variantsData);
                    var matchId = null, matchLabel = '';
                    variants.forEach(function(v){
                        var ok = true;
                        // every selected attr must be present in this variant
                        for (var a in selected) {
                            var wantTid = selected[a];
                            if (!v.pairs.some(function(p){ return p.attr === a && String(p.term_id) === String(wantTid); })) {
                                ok = false; break;
                            }
                        }
                        if (ok) { matchId = v.id; matchLabel = v.label; }
                    });
                    if (matchId) {
                        document.getElementById('variant_id').value = matchId;
                        document.getElementById('variant_name').value = matchLabel;
                    }
                });
            });
            // preselect first chip per attribute
            var groups = document.querySelectorAll('[data-attr]');
            groups.forEach(function(group){
                var first = group.querySelector('.variant-chip');
                if (first) first.click();
            });
        })();
    </script>
@endpush
