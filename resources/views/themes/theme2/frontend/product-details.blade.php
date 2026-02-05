@extends('layouts.frontend')

@section('title', ($product->title ?? 'Product Details') . ' - E-Commerce')

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
            $flashSalePrice = $activeFlashSale->pivot->flash_price;
            $flashDiscountPercent = $activeFlashSale->pivot->flash_discount_percent ?? $activeFlashSale->discount_percent ?? 0;
            // Fallback: Calculate if pivot price is missing but discount exists
            if (!$flashSalePrice && $flashDiscountPercent > 0) {
                 $flashSalePrice = $price - ($price * $flashDiscountPercent / 100);
            }
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
    $effectivePrice = $finalPrice;

    $stockQty = $product->stock_quantity ?? 0;
    $inStock = $stockQty > 0 || ($product->allow_backorder ?? false);

    $category = $product->categories && $product->categories->count() > 0 ? $product->categories->first() : null;

    $purchaseMin = $purchaseMin ?? null;
    $purchaseMax = $purchaseMax ?? null;

    // Get price range if product has variants
    $priceRange = null;
    $hasVariants = false;
    $rawPriceRange = null;

    if (isset($product->variants) && $product->variants->count() > 0) {
        $priceRange = $product->formatted_price_range ?? null;
        $rawPriceRange = $product->price_range ?? null;
        $hasVariants = true;
    }

    // Pre-render short description (supports TinyMCE HTML or plain text)
    $shortDescRaw = $product->short_desc ?? '';
    $shortDescHasMarkup = \Illuminate\Support\Str::contains($shortDescRaw, [
        '<p',
        '<br',
        '<ul',
        '<ol',
        '<li',
        '<div',
        '<span',
    ]);
    $shortDescHtml = $shortDescHasMarkup ? $shortDescRaw : nl2br(e($shortDescRaw));
@endphp

@section('content')
    <style>
        :root {
            --pd-primary: var(--primary-red);
            --pd-secondary: var(--dark-red);
        }
        .product-details .product-price h6.text-dark {
            color: #212529 !important; /* Force dark color */
        }
        .product-details .product-price h6.text-muted {
            color: #6c757d !important; /* Force muted color */
        }
        .flash-sale-countdown .badge {
            min-width: 40px; /* Ensure badges have width */
        }

        /* Fix for Theme 2 Layout Issues */
        .product-details__slider {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        /* 1:1 Aspect Ratio for Main Image */
        .product-details .product-details-slider-single {
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff; /* Optional: white background */
            border-radius: 8px; /* Optional: smooth corners */
            overflow: hidden;
        }

        /* Override Theme 2 main.css specifics to match Theme 1 style */
        .product-details .product-details-slider-single img {
            min-height: auto !important; 
            width: 100%;
            height: 100%;
            object-fit: contain; /* Ensures the whole image is visible within the square */
        }
        
        /* Thumbnails Gallery Styling */
        .product-details-slider-gallery {
            margin-top: 15px;
        }
        
        .product-details .sm-gallery {
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid #eee;
            border-radius: 4px;
            overflow: hidden;
        }

        .product-details .sm-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Highlight active thumbnail */
        .swiper-slide-thumb-active .sm-gallery {
            border-color: var(--pd-primary);
        }

        /* Ensure columns behave correctly */
        .col-md-5, .col-lg-5 {
            /* Force bootstrap width if needed, though bootstrap usually handles this. */
            /* If swiper expands the parent, we might need to constrain flex-basis */
        }
    </style>
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
                <div class="col-12 col-md-7 col-lg-7">
                    <div class="product-details__content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="mt-0 product-meta">
                            <h3 class="mb-1 title-animation">{{ $product->title }}</h3>
                        </div>
                        <div class="mt-0 product-price">
                            @if ($hasVariants && $priceRange)
                                @php
                                    $minPrice = $rawPriceRange['min'] ?? 0;
                                    $maxPrice = $rawPriceRange['max'] ?? 0;
                                    $finalMin = $minPrice;
                                    $finalMax = $maxPrice;
                                    $hasDiscount = false;

                                    // Determine effective discount percent
                                    $effectiveDiscountPercent = 0;
                                    if ($isFlashSale && $flashDiscountPercent > 0) {
                                        $effectiveDiscountPercent = $flashDiscountPercent;
                                        $hasDiscount = true;
                                    } elseif ($isOnSale && $discountPercent > 0) {
                                        $effectiveDiscountPercent = $discountPercent;
                                        $hasDiscount = true;
                                    }

                                    // Apply discount
                                    if ($effectiveDiscountPercent > 0) {
                                        $finalMin = $minPrice - ($minPrice * $effectiveDiscountPercent / 100);
                                        $finalMax = $maxPrice - ($maxPrice * $effectiveDiscountPercent / 100);
                                    } elseif ($isFlashSale && $flashSalePrice) {
                                        // Fallback for fixed price flash sale on variants
                                        $finalMin = $flashSalePrice;
                                        $finalMax = $flashSalePrice;
                                        $hasDiscount = true;
                                    }
                                @endphp

                                @if ($hasDiscount && $finalMin < $minPrice)
                                    <div class="d-flex flex-column align-items-start">
                                        <div class="gap-2 mb-1 d-flex align-items-center">
                                            <div class="mb-0 fw-bold text-theme-primary price-current fs-12">
                                                @if ($finalMin <= 0 && $finalMax > 0)
                                                    ৳{{ number_format($finalMax, 0) }}
                                                @elseif ($finalMin == $finalMax)
                                                    ৳{{ number_format($finalMin, 0) }}
                                                @else
                                                    ৳{{ number_format($finalMin, 0) }} - ৳{{ number_format($finalMax, 0) }}
                                                @endif
                                            </div>
                                            <div class="mb-0 text-decoration-line-through text-muted fs-13" style="font-size: 0.9em;">
                                                @if ($minPrice <= 0 && $maxPrice > 0)
                                                    ৳{{ number_format($maxPrice, 0) }}
                                                @elseif ($minPrice == $maxPrice)
                                                    ৳{{ number_format($minPrice, 0) }}
                                                @else
                                                    ৳{{ number_format($minPrice, 0) }} - ৳{{ number_format($maxPrice, 0) }}
                                                @endif
                                            </div>
                                        </div>
                                        <small class="text-success fw-600">
                                            <i class='bx bx-purchase-tag'></i> Save {{ $effectiveDiscountPercent }}%
                                        </small>
                                    </div>
                                @else
                                    <div class="mb-0 fw-bold text-dark price-current fs-12">
                                        @if ($minPrice <= 0 && $maxPrice > 0)
                                            ৳{{ number_format($maxPrice, 0) }}
                                        @elseif ($minPrice == $maxPrice)
                                            ৳{{ number_format($minPrice, 0) }}
                                        @else
                                            ৳{{ number_format($minPrice, 0) }} - ৳{{ number_format($maxPrice, 0) }}
                                        @endif
                                    </div>
                                @endif
                            @elseif ($finalPrice < $originalPrice)
                                <div class="d-flex flex-column align-items-start">
                                    <div class="gap-2 mb-1 d-flex align-items-center">
                                        <h4 class="mb-0 fw-bold text-dark">৳{{ number_format($finalPrice, 0) }}</h4>
                                        <h6 class="mb-0 text-decoration-line-through text-muted" style="font-size: 0.9em;">৳{{ number_format($originalPrice, 0) }}</h6>
                                    </div>
                                    @if ($discountPercent > 0)
                                        <small class="text-success fw-600">
                                            <i class='bx bx-purchase-tag'></i> Save {{ $discountPercent }}%
                                        </small>
                                    @endif
                                </div>
                            @else
                                <h4 class="mb-0 fw-bold text-dark">৳{{ number_format($price, 0) }}</h4>
                            @endif
                        </div>

                        @if ($isFlashSale && isset($activeFlashSale) && $activeFlashSale->end_time > now())
                            <div class="p-2 mt-3 mb-3 rounded border bg-light border-theme-primary" style="border-style: dashed !important;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-theme-primary fw-bold small"><i class='bx bxs-bolt'></i> Flash Sale Ends:</span>
                                    <div class="flash-sale-countdown d-flex align-items-center" data-end-time="{{ $activeFlashSale->end_time->timestamp * 1000 }}">
                                        <span class="p-2 badge bg-dark me-1"><span class="fs-days">00</span>d</span>
                                        <span class="p-2 badge bg-dark me-1"><span class="fs-hours">00</span>h</span>
                                        <span class="p-2 badge bg-dark me-1"><span class="fs-minutes">00</span>m</span>
                                        <span class="p-2 badge bg-dark"><span class="fs-seconds">00</span>s</span>
                                    </div>
                                </div>
                            </div>
                            <script>
                                (function() {
                                    function initCountdown() {
                                        const containers = document.querySelectorAll('.flash-sale-countdown');
                                        if (!containers.length) return;

                                        containers.forEach(container => {
                                            const endTimeAttr = container.getAttribute('data-end-time');
                                            if (!endTimeAttr) return;

                                            const endTime = parseInt(endTimeAttr);
                                            if (isNaN(endTime)) return;

                                            const pad = (n) => (n < 10 ? "0" + n : n);

                                            const updateTimer = () => {
                                                const now = new Date().getTime();
                                                const distance = endTime - now;

                                                if (distance >= 0) {
                                                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                    const dEl = container.querySelector('.fs-days');
                                                    const hEl = container.querySelector('.fs-hours');
                                                    const mEl = container.querySelector('.fs-minutes');
                                                    const sEl = container.querySelector('.fs-seconds');

                                                    if(dEl) dEl.textContent = pad(days);
                                                    if(hEl) hEl.textContent = pad(hours);
                                                    if(mEl) mEl.textContent = pad(minutes);
                                                    if(sEl) sEl.textContent = pad(seconds);
                                                } else {
                                                    container.innerHTML = '<span class="text-danger fw-bold">Ended</span>';
                                                    if(container.timerInterval) clearInterval(container.timerInterval);
                                                }
                                            };

                                            if(container.timerInterval) clearInterval(container.timerInterval);
                                            container.timerInterval = setInterval(updateTimer, 1000);
                                            updateTimer(); // Run immediately
                                        });
                                    }

                                    if (document.readyState === 'loading') {
                                        document.addEventListener('DOMContentLoaded', initCountdown);
                                    } else {
                                        initCountdown();
                                    }
                                })();
                            </script>
                        @endif

                        <div class="mb-4 border card client-details-inner rounded-3">
                            <div class="card-header">
                                <h6 class="mb-0 sub-title-main fs-16 fw-600 lh-sm"><i class="bx bxs-analyse"></i>Quick
                                    Overview</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                        <i class="bx bx-hash me-1"></i>
                                        SKU
                                    </span>
                                    <p class="p-0 m-0 w-60 text-dark">{{ $product->sku ?? 'N/A' }}</p>
                                </div>
                                <div class="pt-2 d-flex align-items-center justify-content-between">
                                    <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                        <i class="bx bx-category me-1"></i>
                                        Category
                                    </span>
                                    <p class="p-0 m-0 w-60 text-dark">{{ $category->name ?? 'N/A' }}</p>
                                </div>
                                @if ($product->brand)
                                    <div class="pt-2 d-flex align-items-center justify-content-between">
                                        <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                            <i class="bx bx-purchase-tag me-1"></i>
                                            Brand
                                        </span>
                                        <p class="p-0 m-0 w-60 text-dark">{{ $product->brand->name }}</p>
                                    </div>
                                @endif
                                <div class="pt-2 d-flex align-items-center justify-content-between">
                                    <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                                        <i class="bx bx-check-circle me-1"></i>
                                        Availability
                                    </span>
                                    <p class="w-60 {{ $inStock ? 'text-success' : 'text-danger' }} p-0 m-0">
                                        {{ $inStock ? 'In Stock' : 'Out of Stock' }}</p>
                                </div>
                            </div>
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

                                <div class="variant-options-container">
                                    @foreach ($axes as $attrName => $terms)
                                        @php
                                            $isColor =
                                                stripos($attrName, 'color') !== false ||
                                                stripos($attrName, 'colour') !== false;
                                        @endphp
                                        <div class="mb-2 variant-option-group">
                                            <label class="mb-2 variant-label fw-600 fs-14 d-block" style="color: #333;">
                                                {{ $attrName }}:
                                            </label>

                                            @if ($isColor)
                                                <div class="variant-colors-wrapper">
                                                    @foreach ($terms as $tid => $tname)
                                                        <div class="variant-chip-wrapper">
                                                            <button type="button"
                                                                class="variant-color-chip variant-chip-btn"
                                                                style="background-color: {{ strtolower($tname) }};"
                                                                data-attr="{{ $attrName }}"
                                                                data-term-id="{{ $tid }}"
                                                                data-term-name="{{ $tname }}"
                                                                title="{{ $tname }}" onclick="return false;">
                                                                <i class="bx bx-x deselect-icon-color"
                                                                    style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 1.2rem; color: white; text-shadow: 0 0 3px rgba(0,0,0,0.5);"></i>
                                                                <span class="color-label">{{ $tname }}</span>
                                                            </button>
                                                            <span class="availability-badge" style="display: none;"></span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="variant-options-grid">
                                                    @foreach ($terms as $tid => $tname)
                                                        <div class="variant-chip-wrapper">
                                                            <button type="button"
                                                                class="variant-option-btn variant-chip-btn action-btn-success"
                                                                data-attr="{{ $attrName }}"
                                                                data-term-id="{{ $tid }}"
                                                                data-term-name="{{ $tname }}">
                                                                <span class="btn-text">{{ $tname }}</span>
                                                                <i class="bx bx-x deselect-icon"
                                                                    style="display: none;"></i>
                                                                <span class="availability-badge"
                                                                    style="display: none; font-size: 0.65rem; margin-left: 3px;"></span>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Stock Information - Shows only when variant is selected -->
                                <div id="variant-stock-info" class="p-3 mb-4 border alert alert-light d-none"
                                    style="background: #f8f9fa;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <strong>Stock Available:</strong>
                                            <span id="stock-quantity" class="ms-2 badge bg-success"
                                                style="font-size: 0.9rem;">-</span>
                                        </div>
                                        <div>
                                            <strong>SKU:</strong>
                                            <span id="variant-sku" class="ms-2 text-muted">-</span>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="variant_id" id="variant_id" value="">
                                <input type="hidden" name="variant" id="variant_name" value="">
                                <input type="hidden" name="variant_price" id="variant_price" value="">
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

                        <div class="sku">
                            <p><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</p>
                            @if ($category)
                                <p><strong>Category:</strong> {{ $category->name }}</p>
                            @endif
                            <!-- Tags could be added here if available in model -->
                        </div>

                        <div class="mt-3 product-actions d-flex align-items-center justify-content-between">
                            <button class="p-3 border-0 action-btn-warning h-30px w-30 rounded-3 add-to-wishlist"
                                data-product-id="{{ $product->id }}">
                                <i class='bx bx-heart'></i> Add to Wishlist
                            </button>
                            <button class="p-3 border-0 action-btn-primary ms-2 h-30px w-30 rounded-3" id="compareBtn">
                                <i class='bx bx-git-compare'></i> Compare
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    <div id="sizeChartModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <span class="close-btn" data-bs-dismiss="modal">&times;</span>
                <div class="size-chart-content">
                    <h4 class="mb-3">Size Chart</h4>
                    <img src="{{ asset('frontend/assets/images/size-chart.png') }}" alt="Size Chart Image"
                        class="img-fluid">
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
                                            <p class="mb-0 text-muted">No description available.</p>
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
                                        <div class="mb-4 col-lg-4">
                                            <!-- Review Summary -->
                                            <div class="p-4 review-summary bg-light rounded-3">
                                                <h4 class="mb-3">Customer Reviews</h4>
                                                <div class="mb-3 d-flex align-items-center">
                                                    <span class="display-4 fw-bold me-3">{{ number_format($avgRating, 1) }}</span>
                                                    <div>
                                                        <div class="mb-1 stars">
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
                                            <div class="mt-3 collapse" id="reviewFormCollapse">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6 class="mb-3">Write Your Review</h6>
                                                        <form action="{{ route('product.review', $product->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="form-label">Your Rating</label>
                                                                <div class="gap-2 rating-input d-flex">
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
                                                        <div class="pb-4 mb-4 review-item border-bottom">
                                                            <div class="d-flex align-items-start">
                                                                <div class="review-avatar me-3">
                                                                    @if($review->reviewer_image)
                                                                        <img src="{{ asset('storage/' . $review->reviewer_image) }}"
                                                                             alt="{{ $review->reviewer_name }}"
                                                                             class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                                    @else
                                                                        <div class="text-white rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                                                             style="width: 50px; height: 50px; font-size: 1.2rem;">
                                                                            {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="review-content flex-grow-1">
                                                                    <div class="mb-2 d-flex justify-content-between align-items-start">
                                                                        <div>
                                                                            <strong>{{ $review->reviewer_name }}</strong>
                                                                            @if($review->verified_purchase)
                                                                                <span class="badge bg-success ms-2"><i class="bx bx-check"></i> Verified Purchase</span>
                                                                            @endif
                                                                            <div class="stars" style="display: flex; gap: 3px; margin-top: 6px;">
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 0.9rem; flex-shrink: 0;"></i>
                                                                                @endfor
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                                    </div>
                                                                    @if ($review->title)
                                                                        <h6 class="mb-2">"{{ $review->title }}"</h6>
                                                                    @endif
                                                                    <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if ($reviews->hasPages())
                                                    <div class="mt-4">
                                                        {{ $reviews->links() }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="py-5 text-center">
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
                                        <div class="mb-3 rounded border accordion-item">
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
                                        <div class="mb-3 rounded border accordion-item">
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
                                        <div class="mb-3 rounded border accordion-item">
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
            --pd-primary: var(--primary-color, #0496ff);
            --pd-secondary: var(--secondary-color, #1a1a2e);
            --pd-accent: var(--accent-color, #f9c123);
        }

        /* Override button colors to use theme variables */
        .action-btn-success {
            background-color: var(--pd-primary) !important;
            color: var(--button-text-color, #ffffff) !important;
            border: none !important;
        }

        .action-btn-success:hover {
            background-color: color-mix(in srgb, var(--pd-primary) 85%, black) !important;
        }

        .action-btn-warning {
            background-color: var(--pd-accent) !important;
            color: #000 !important;
        }

        .action-btn-warning:hover {
            background-color: color-mix(in srgb, var(--pd-accent) 85%, black) !important;
        }

        .action-btn-primary {
            background-color: var(--pd-primary) !important;
            color: var(--secondary-button-text, #ffffff) !important;
        }

        .action-btn-primary:hover {
            background-color: color-mix(in srgb, var(--pd-primary) 85%, black) !important;
        }

        /* Price color */
        .product-price h6.text-danger {
            color: var(--pd-primary) !important;
        }

        /* Quantity selector */
        .measure button {
            color: var(--pd-secondary) !important;
        }

        .measure button:hover {
            color: var(--pd-primary) !important;
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
            background: var(--pd-primary);
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
            background: var(--pd-primary);
            color: var(--pd-secondary);
        }

        .accordion-button {
            background: var(--pd-primary);
            color: #fff;
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
                document.querySelector('.item-quantity').textContent = input.value;
            }
        }

        function decreaseQty() {
            var input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                document.querySelector('.item-quantity').textContent = input.value;
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
                            if (v.inStock === false || (v.inStock === undefined && v.stock <=
                                0)) return;
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

    <style>
        .variant-options-container {
            margin: 1rem 0;
            padding: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .variant-option-group {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .variant-option-group:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .variant-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            letter-spacing: 0.2px;
            text-transform: capitalize;
            display: block;
            margin-bottom: 0.5rem !important;
        }

        /* Wrapper for each chip */
        .variant-chip-wrapper {
            position: relative;
            display: inline-block;
        }

        .availability-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            padding: 0.25rem 0.5rem;
            border-radius: 50%;
            font-size: 0.7rem;
            font-weight: 700;
            z-index: 10;
        }

        .availability-badge.in-stock {
            background: #10b981;
            color: white;
        }

        .availability-badge.out-of-stock {
            background: #ef4444;
            color: white;
        }

        /* Color Chips Styling */
        .variant-colors-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(45px, 1fr));
            gap: 0.5rem;
        }

        .variant-color-chip {
            position: relative;
            width: 45px;
            height: 45px;
            border: 2px solid #e5e7eb;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .variant-color-chip:hover:not(.disabled) {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            border-color: #d1d5db;
        }

        .variant-color-chip.active {
            border-color: #059669;
            border-width: 4px;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1), 0 6px 16px rgba(5, 150, 105, 0.3);
        }

        .variant-color-chip .deselect-icon-color {
            display: none !important;
            opacity: 0;
        }

        .variant-color-chip.active .deselect-icon-color {
            display: block !important;
            opacity: 1;
        }

        .variant-color-chip.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(0, 0, 0, 0.1) 10px,
                    rgba(0, 0, 0, 0.1) 20px);
        }

        .variant-color-chip .color-label {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .variant-color-chip:hover:not(.disabled) .color-label {
            opacity: 1;
            bottom: -32px;
        }

        /* Options Grid Styling */
        .variant-options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(70px, auto));
            gap: 0.5rem;
        }

        .variant-option-btn {
            padding: 0.5rem 0.75rem;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            background: white;
            color: #374151;
            font-weight: 500;
            font-size: 0.8rem;
            white-space: nowrap;
            width: auto;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            gap: 0.25rem;
        }

        .variant-option-btn .btn-text {
            flex-shrink: 0;
        }

        .variant-option-btn .deselect-icon {
            font-size: 1rem;
            margin-left: 0.25rem;
            opacity: 0;
            display: none !important;
            transition: opacity 0.2s;
        }

        .variant-option-btn.active .deselect-icon {
            opacity: 0.8;
            display: inline-block !important;
        }

        .variant-option-btn.active .deselect-icon:hover {
            opacity: 1;
        }

        .variant-option-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(5, 150, 105, 0.1);
            transition: left 0.3s ease;
            z-index: 0;
        }

        .variant-option-btn:hover:not(.disabled) {
            border-color: #059669;
            color: #059669;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
            transform: translateY(-2px);
        }

        .variant-option-btn:hover:not(.disabled)::before {
            left: 0;
        }

        .variant-option-btn:active:not(.disabled) {
            transform: translateY(0);
        }

        .variant-option-btn.active {
            background: var(--qbit-success, #10b981) !important;
            color: white !important;
            border-color: var(--qbit-success, #10b981) !important;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }

        .variant-option-btn.active::before {
            background: transparent;
        }

        .variant-option-btn.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: #f3f4f6;
            border-color: #d1d5db;
            color: #9ca3af;
        }

        .variant-option-btn.disabled::before {
            background: transparent;
        }

        .variant-option-btn.disabled:hover {
            transform: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border-color: #d1d5db;
            color: #9ca3af;
        }

        /* Stock Info Styling */
        #variant-stock-info {
            border-left: 5px solid #059669;
            background: linear-gradient(135deg, #f0fdf4 0%, #f3f4f6 100%);
            border-radius: 12px;
            padding: 1.25rem !important;
            border: 1px solid #d1fae5;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.1);
        }

        #variant-stock-info strong {
            color: #065f46;
            font-weight: 600;
        }

        #stock-quantity {
            font-size: 1rem !important;
            padding: 0.5rem 1rem !important;
            background: #059669;
            border-radius: 8px;
            font-weight: 600;
        }

        #stock-quantity.out-of-stock {
            background: #ef4444;
        }

        #variant-sku {
            font-weight: 500;
            font-family: 'Courier New', monospace;
            background: rgba(5, 150, 105, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            color: #065f46;
        }

        /* Selection Message */
        #variant-selection-message {
            background: linear-gradient(135deg, #dbeafe 0%, #f3f4f6 100%);
            border: 1px solid #bfdbfe;
            border-left: 5px solid #3b82f6;
            border-radius: 10px;
            color: #1e40af;
        }

        #variant-selection-message i {
            color: #3b82f6;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .variant-options-container {
                padding: 1.5rem;
                margin: 1.5rem 0;
            }

            .variant-option-group {
                margin-bottom: 2rem;
                padding-bottom: 2rem;
            }

            .variant-colors-wrapper {
                grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
                gap: 0.75rem;
            }

            .variant-color-chip {
                width: 50px;
                height: 50px;
            }

            .variant-options-grid {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
                gap: 0.75rem;
            }

            .variant-option-btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
        }

        /* Rating Input Styles */
        .rating-input {
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating-input .rating-star i {
            transition: color 0.2s;
        }

        .rating-input input:checked ~ label i,
        .rating-input label:hover i,
        .rating-input label:hover ~ label i {
            color: #fbbf24 !important;
        }

        .rating-input label:hover ~ label i {
            color: #fbbf24 !important;
        }

        /* Review styles */
        .review-summary {
            border: 1px solid #e5e7eb;
        }

        .review-item:last-child {
            border-bottom: none !important;
        }
    </style>

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
