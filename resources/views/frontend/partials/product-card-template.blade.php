@php
    // Get all valid images
    $images = collect();

    // 1. Prioritize images relationship
    if (
        isset($product->images) &&
        $product->images &&
        $product->images instanceof \Illuminate\Support\Collection &&
        $product->images->count() > 0
    ) {
        // Sort by cover image first, then others
        $images = $product->images->sortByDesc('is_cover');
    }
    // 2. Fallback to direct attribute if no images in relationship
    elseif (isset($product->cover_image) && $product->cover_image) {
        $images->push((object) ['path' => $product->cover_image]);
    } elseif (isset($product->coverImage) && $product->coverImage) {
        $images->push($product->coverImage);
    }

    // Ensure we have at least one image
    if ($images->isEmpty()) {
        $images->push((object) ['path' => null]); // No dummy, just null
    }

    $uniqueImages = $images->unique(function ($item) {
        return $item->path ?? ($item->image ?? '');
    });

    // Get price
    $price = $product->price ?? 0;
    $salePrice = $product->sale_price ?? null;

    // Check for active flash sale
    $flashSalePrice = null;
    $flashDiscountPercent = 0;
    $isFlashSale = false;

    if (method_exists($product, 'getActiveFlashSaleAttribute')) {
        $activeFlashSale = $product->active_flash_sale;
        if ($activeFlashSale) {
            $flashSalePrice = $activeFlashSale->pivot->flash_price ?? null;
            $flashDiscountPercent = $activeFlashSale->pivot->flash_discount_percent ?? 0;

            // Fallback to general flash sale discount if not overridden per product
            if ($flashDiscountPercent <= 0 && (!$flashSalePrice || $flashSalePrice <= 0)) {
                 $flashDiscountPercent = $activeFlashSale->discount_percent ?? 0;
            }

            // Calculate flash price if only percent is available
            if ((!$flashSalePrice || $flashSalePrice <= 0) && $flashDiscountPercent > 0) {
                $flashSalePrice = $price - ($price * ($flashDiscountPercent / 100));
            }

            $isFlashSale = true;
        }
    }


    // Always show the lowest price (flash, sale, or regular)
    $candidates = [$price];
    if ($salePrice && $salePrice < $price) $candidates[] = $salePrice;
    if ($isFlashSale && $flashSalePrice && $flashSalePrice < $price) $candidates[] = $flashSalePrice;
    $finalPrice = min($candidates);
    $originalPrice = $price;
    $isOnSale = $finalPrice < $price;
    // Discount percent: from original price to final price
    $discountPercent = $isOnSale && $price > 0 ? round((($price - $finalPrice) / $price) * 100) : 0;

    // Get price range if product has variants
    $priceRange = null;
    $hasVariants = false;
    $rawPriceRange = null;

    if (isset($product->variants) && $product->variants->count() > 0) {
        $priceRange = $product->formatted_price_range ?? null;
        $rawPriceRange = $product->price_range ?? null;
        $hasVariants = true;
    }

    // Get stock
    $stockQty = $product->stock_quantity ?? 0;
    $inStock = $stockQty > 0 || ($product->allow_backorder ?? false);

    // Get category
    $categoryName = 'Uncategorized';
    if (is_object($product) && (property_exists($product, 'categories') || method_exists($product, 'categories'))) {
        if (property_exists($product, 'categories')) {
            if ($product->categories && $product->categories->count() > 0) {
                $categoryName = $product->categories->first()->name ?? 'Uncategorized';
            }
        } elseif (method_exists($product, 'categories')) {
            if ($product->categories()->count() > 0) {
                $categoryName = $product->categories()->first()->name ?? 'Uncategorized';
            }
        }
    }

    // Check if new (within 30 days)
    $isNew = false;
    if ($product->created_at) {
        try {
            $createdDate = is_string($product->created_at)
                ? \Carbon\Carbon::parse($product->created_at)
                : $product->created_at;
            $isNew = $createdDate->diffInDays(now()) < 30;
        } catch (\Exception $e) {
            $isNew = false;
        }
    }
    $wishlistItems = session()->get('wishlist', []);

    // Get product details for wishlist items
    $wishlistProductIds = array_keys($wishlistItems);

    $hasInWishList = in_array($product->id, $wishlistProductIds);

@endphp

@once
    <style>
        .property-single-boxarea {
            position: relative;
        }

        .property-list-img-area {
            position: relative;
            z-index: 1;
        }

        .product-card-swiper {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .product-card-swiper .swiper-wrapper {
            width: 100%;
            height: 100%;
            z-index: 1;
            display: flex;
            /* Ensure flex behavior */
        }

        .product-card-swiper .swiper-slide {
            width: 100%;
            height: 100%;
            flex-shrink: 0;
            /* Prevent shrinking */
            position: relative;
        }

        .property-single-boxarea:hover .swiper-button-next,
        .property-single-boxarea:hover .swiper-button-prev {
            opacity: 1;
            visibility: visible;
        }

        .product-card-swiper .swiper-button-next,
        .product-card-swiper .swiper-button-prev {
            width: 25px;
            height: 25px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            color: #333;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .product-card-swiper .swiper-button-next::after,
        .product-card-swiper .swiper-button-prev::after {
            font-size: 10px;
            font-weight: bold;
        }

        .product-card-swiper .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.6;
        }

        .product-card-swiper .swiper-pagination-bullet-active {
            background: var(--primary-color, #0496ff);
            opacity: 1;
        }

        .property-single-boxarea .title-animation a {
            font-size: clamp(0.95rem, 2.2vw, 1.15rem);
            line-height: 1.25;
        }

        .property-single-boxarea .product-category {
            font-size: clamp(0.75rem, 1.6vw, 0.9rem);
        }

        .property-single-boxarea .price-current {
            font-size: clamp(0.95rem, 2vw, 1.15rem);
        }

        .property-single-boxarea .price-old {
            font-size: clamp(0.8rem, 1.6vw, 0.95rem);
        }

        .property-single-boxarea .badge {
            font-size: clamp(0.6rem, 1.4vw, 0.75rem);
        }

        .property-single-boxarea .btn-area1 a {
            color: #fff;
        }

        .property-single-boxarea .btn-area1 .btn-view {
            background: var(--home-secondary, #1a1a2e);
            border-color: var(--home-secondary, #1a1a2e);
            color: #fff !important;
        }

        .property-single-boxarea .btn-area1 .btn-cart {
            background: var(--home-primary, #0496ff);
            border-color: var(--home-primary, #0496ff);
            color: #fff !important;
        }

        .property-single-boxarea .btn-area1 .btn-wishlist {
            color: #fff !important;
        }

        .property-single-boxarea .btn-area1 .action-btn-soft-success {
            background-color: var(--qbit-green-40);
            color: #fff;
            border-color: var(--qbit-green-40);
        }

        .property-single-boxarea .btn-area1 .action-btn-soft-success:hover,
        .property-single-boxarea .btn-area1 .action-btn-soft-success:focus,
        .property-single-boxarea .btn-area1 .action-btn-soft-success:active {
            background-color: var(--qbit-green-80);
            border-color: var(--qbit-green-80);
            color: #fff;
        }

        .property-single-boxarea .btn-area1 .action-btn-soft-success *,
        .property-single-boxarea .btn-area1 .action-btn-soft-success:hover *,
        .property-single-boxarea .btn-area1 .action-btn-soft-success:focus *,
        .property-single-boxarea .btn-area1 .action-btn-soft-success:active * {
            color: #fff;
        }

        @media (max-width: 576px) {
            .property-single-boxarea .title-animation a {
                font-size: 14px;
            }

            .property-single-boxarea .product-category {
                font-size: 0.95rem;
            }

            .property-single-boxarea .price-current {
                font-size: 1.25rem;
            }

            .property-single-boxarea .price-old {
                font-size: 1rem;
            }

            .property-single-boxarea .badge {
                font-size: 0.8rem;
            }

            .property-single-boxarea {
                padding-bottom: 64px;
            }

            .property-single-boxarea .btn-area1 {
                position: absolute;
                margin-block: 15px !important;
                gap: 8px;
                background: transparent;
                animation: mobileSlideUp .3s ease-out both;
                z-index: 3;
            }

            /* .property-single-boxarea .btn-area1 .action-btn-success {
                                    width: 100%;
                                    justify-content: center;
                                } */

            .property-single-boxarea .btn-area1 .add-to-wishlist,
            .property-single-boxarea .btn-area1 .add-to-cart {
                display: none;

            }

            @keyframes mobileSlideUp {
                from {
                    transform: translateY(20px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        }
    </style>

@endonce

<div class="{{ $colClass ?? 'col-12 col-md-6 col-lg-4 mb-5' }}">
    <div class="p-0 property-single-boxarea d-flex flex-column" data-aos="fade-up" data-aos-duration="1000">
        <div class="property-list-img-area position-relative">
            <div class="overflow-hidden img1 position-relative" style="aspect-ratio: 1/1;">

                @php
                    $showOffer = $isOnSale;
                    $offerPrice = $finalPrice;

                    if ($hasVariants && $isFlashSale && $rawPriceRange) {
                         $minP = $rawPriceRange['min'] ?? 0;
                         $finalMinP = $minP;
                         if ($flashDiscountPercent > 0) {
                             $finalMinP = $minP - ($minP * $flashDiscountPercent / 100);
                         } elseif ($flashSalePrice) {
                             $finalMinP = $flashSalePrice;
                         }

                         if ($finalMinP < $minP) {
                             $showOffer = true;
                             $offerPrice = $finalMinP;
                         }
                    }
                @endphp

                @if ($showOffer)
                    <span class="top-0 px-3 py-1 m-2 text-white position-absolute start-0 rounded-pill bg-danger fw-bold fs-14 z-3" style="z-index:20;">
                        Offer ৳{{ number_format($offerPrice, 0) }}
                    </span>
                @endif

                @php
                    $swiperId = 'shop-swiper-' . ($product->id ?? uniqid());
                @endphp

                @if ($uniqueImages->count() > 1)
                    <!-- Swiper Slider -->
                    <div class="swiper product-card-swiper" id="{{ $swiperId }}">
                        <div class="swiper-wrapper">
                            @foreach ($uniqueImages as $image)
                                @php
                                    $path = $image->path ?? ($image->image ?? null);
                                @endphp
                                <div class="swiper-slide">
                                    @if ($path)
                                        <img src="{{ asset('storage/' . $path) }}"
                                            alt="{{ $product->title ?? 'Product' }}"
                                            class="w-100 h-100 object-fit-cover" loading="lazy">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination" id="{{ $swiperId }}-pagination"></div>
                        <div class="swiper-button-prev" id="{{ $swiperId }}-prev"></div>
                        <div class="swiper-button-next" id="{{ $swiperId }}-next"></div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            new Swiper('#{{ $swiperId }}', {
                                loop: false,
                                slidesPerView: 1,
                                spaceBetween: 0,
                                pagination: {
                                    el: '#{{ $swiperId }}-pagination',
                                    clickable: true,
                                    dynamicBullets: true,
                                },
                                navigation: {
                                    nextEl: '#{{ $swiperId }}-next',
                                    prevEl: '#{{ $swiperId }}-prev',
                                },
                                on: {
                                    init: function() {
                                        // Prevent link clicks when swiping
                                        this.el.addEventListener('click', function(e) {
                                            if (this.swiper && this.swiper.animating) {
                                                e.preventDefault();
                                                e.stopPropagation();
                                            }
                                        });
                                    }
                                }
                            });
                        });
                    </script>
                @else
                    <!-- Static Image (Single) -->
                    @php
                        $firstImage = $uniqueImages->first();
                        $path = $firstImage->path ?? ($firstImage->image ?? null);
                    @endphp
                    <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="d-block w-100 h-100">
                        @if ($path)
                            <img src="{{ asset('storage/' . $path) }}" alt="{{ $product->title ?? 'Product' }}"
                                class="w-100 h-100 object-fit-cover" loading="lazy">
                        @endif
                    </a>
                @endif
                @if ($isNew)
                    <span class="border-0 select-btn-danger h-16px fs-12 fw-600 qb-bg-danger-50">New</span>
                @endif
                @if ($isFlashSale)
                    <span class="text-white border-0 select-btn-base h-16px fs-12 fw-600" style="background: #FF4500;">
                        <i class='bx bxs-bolt'></i> Flash Sale
                    </span>
                @elseif ($isOnSale && $discountPercent > 0)
                    <span
                        class="border-0 select-btn-success h-16px fs-12 fw-600 qb-bg-success-50">-{{ $discountPercent }}%</span>
                @endif
                @if ($product->featured ?? false)
                    <span class="border-0 select-btn-base h-16px fs-12 fw-600 qb-bg-base-50">Hot</span>
                @endif
            </div>

            @if (!$inStock)
                <div class="bottom-0 py-2 text-center position-absolute start-0 end-0"
                    style="background: rgba(220, 53, 69, 0.9); z-index: 2;">
                    <span class="text-white fw-bold small">Sold Out</span>
                </div>
            @endif
        </div>

        <div class="flex-grow-0 property-single-content">
            <h4>
                <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="d-block text-truncate"
                    title="{{ $product->title ?? 'Product' }}">
                    {{ $product->title }}
                </a>
                <p class="p-0 m-0 mt-1 product-category lh-sm"><i class='bx bxs-tag me-1'></i>{{ $categoryName }}</p>
            </h4>
        </div>

        <div class="property-details">
            <ul class="d-flex align-items-center justify-content-between">
                <li class="m-0 d-flex flex-column align-items-start">
                    @if ($hasVariants && $priceRange)
                        @if ($isFlashSale && $rawPriceRange)
                            @php
                                $minPrice = $rawPriceRange['min'] ?? 0;
                                $maxPrice = $rawPriceRange['max'] ?? 0;
                                $finalMin = $minPrice;
                                $finalMax = $maxPrice;

                                if ($flashDiscountPercent > 0) {
                                    $finalMin = $minPrice - ($minPrice * $flashDiscountPercent / 100);
                                    $finalMax = $maxPrice - ($maxPrice * $flashDiscountPercent / 100);
                                } elseif ($flashSalePrice) {
                                    $finalMin = $flashSalePrice;
                                    $finalMax = $flashSalePrice;
                                }
                            @endphp

                            @if ($finalMin < $minPrice)
                                <div class="gap-2 d-flex align-items-center">
                                    <span class="text-dark fw-bold price-current fs-18">
                                        @if ($finalMin == $finalMax)
                                            ৳{{ number_format($finalMin, 0) }}
                                        @else
                                            ৳{{ number_format($finalMin, 0) }} - ৳{{ number_format($finalMax, 0) }}
                                        @endif
                                    </span>
                                    <span class="text-decoration-line-through text-muted price-old fs-14">
                                        @if ($minPrice == $maxPrice)
                                            ৳{{ number_format($minPrice, 0) }}
                                        @else
                                            ৳{{ number_format($minPrice, 0) }} - ৳{{ number_format($maxPrice, 0) }}
                                        @endif
                                    </span>
                                </div>
                            @else
                                <span class="fw-bold price-current fs-18">{{ $priceRange }}</span>
                            @endif
                        @else
                            <span class="fw-bold price-current fs-18">{{ $priceRange }}</span>
                        @endif
                    @elseif ($finalPrice < $originalPrice)
                        <div class="gap-2 d-flex align-items-center">
                            <span class="text-dark fw-bold price-current fs-18">৳{{ number_format($finalPrice, 0) }}</span>
                            <span class="text-decoration-line-through text-muted price-old fs-14">৳{{ number_format($originalPrice, 0) }}</span>
                        </div>
                        {{-- <small class="mt-1 text-success fw-600">
                            <i class='bx bx-purchase-tag'></i> Discount Price
                        </small> --}}
                    @else
                        <span class="fw-bold price-current fs-18">৳{{ number_format($price, 0) }}</span>
                    @endif
                </li>
                <li class="d-flex align-items-center justify-content-end text-nowrap">
                    <i class='bx bx-package me-0'></i>
                    @if ($inStock)
                        <span class="text-success fs-15 fw-600">In Stock</span>
                    @else
                        <span class="text-danger fs-15 fw-600">Sold Out</span>
                    @endif
                </li>
            </ul>
        </div>

        <div class="p-0 px-3 m-0 text-center btn-area1 d-flex align-items-center justify-content-between">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}"
                class="px-3 w-40 text-white create-btn-info btn-view fs-15 fw-600 h-25px rounded-3 me-2">
                <i class="bx bx-show fs-15 me-1"></i>View
            </a>
            <a type="button" title="Add to Wishlist" data-id="{{ $product->id }}"
                class="px-3 text-white border-0 create-btn-primary btn-wishlist fs-15 fw-600 h-25px w-25px rounded-3 add-to-wishlist bg-red"
                data-has-in-wishlist="{{ $hasInWishList ? 'true' : 'false' }}">
                <i class="bx bxs-heart fs-20 {{ $hasInWishList ? 'text-danger' : '' }}"></i>
            </a>
            @if (isset($hasVariants) && $hasVariants)
                <a href="#" title="Select Options" onclick="openQuickView({{ $product->id }}); return false;"
                    class="px-3 w-40 text-white create-btn-base btn-cart fs-15 fw-600 h-25px rounded-3 ms-2">
                    <i class="bx bxs-cart fs-15 me-1"></i>Add Cart
                </a>
            @else
                <a href="#" title="Add to Cart" data-id="{{ $product->id }}"
                    class="px-3 w-40 text-white create-btn-base btn-cart fs-15 fw-600 h-25px rounded-3 ms-2 add-to-cart">
                    <i class="bx bxs-cart fs-15 me-1"></i>Add Cart
                </a>
            @endif
        </div>
    </div>
</div>
