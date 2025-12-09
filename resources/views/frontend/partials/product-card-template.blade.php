@php
    // Fallback dummy image
    $dummyImage = asset('frontend/assets/images/shop/KHPP-SA21 - 1.png');

    // Get all valid images
    $images = collect();
    
    // 1. Prioritize images relationship
    if (isset($product->images) && $product->images && $product->images instanceof \Illuminate\Support\Collection && $product->images->count() > 0) {
        // Sort by cover image first, then others
        $images = $product->images->sortByDesc('is_cover');
    } 
    // 2. Fallback to direct attribute if no images in relationship
    elseif (isset($product->cover_image) && $product->cover_image) {
        $images->push((object)['path' => $product->cover_image]);
    } elseif (isset($product->coverImage) && $product->coverImage) {
        $images->push($product->coverImage);
    }

    // Ensure we have at least one image (dummy if needed)
    if ($images->isEmpty()) {
        $images->push((object)['path' => null]); // Will trigger dummy image
    }

    $uniqueImages = $images->unique(function ($item) {
        return $item->path ?? $item->image ?? '';
    });

    // Get price
    $price = $product->price ?? 0;
    $salePrice = $product->sale_price ?? null;
    $isOnSale = $salePrice && $salePrice < $price;
    $discountPercent = $isOnSale && $price > 0 ? round((($price - $salePrice) / $price) * 100) : 0;

    // Get stock
    $stockQty = $product->stock_quantity ?? 0;
    $inStock = $stockQty > 0 || ($product->allow_backorder ?? false);

    // Get category
    $categoryName = 'Uncategorized';
    if ($product->categories && $product->categories->count() > 0) {
        $categoryName = $product->categories->first()->name ?? 'Uncategorized';
    }

    // Check if new (within 30 days)
    $isNew = $product->created_at && $product->created_at->diffInDays(now()) < 30;
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
            display: flex; /* Ensure flex behavior */
        }
        
        .product-card-swiper .swiper-slide {
            width: 100%;
            height: 100%;
            flex-shrink: 0; /* Prevent shrinking */
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
    </style>
@endonce

<div class="col-12 col-sm-6 col-md-4 col-lg-4">
    <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
        <div class="property-list-img-area position-relative">
            <div class="img1 position-relative overflow-hidden" style="height: 300px;"> <!-- Increased height for shop page -->
                
                @php
                    $swiperId = 'shop-swiper-' . ($product->id ?? uniqid());
                @endphp
                
                @if($uniqueImages->count() > 1)
                    <!-- Swiper Slider -->
                    <div class="swiper product-card-swiper" id="{{ $swiperId }}">
                        <div class="swiper-wrapper">
                            @foreach($uniqueImages as $image)
                                @php 
                                    $path = $image->path ?? $image->image ?? null; 
                                @endphp
                                <div class="swiper-slide">
                                    <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="d-block w-100 h-100">
                                        @if($path)
                                            <img src="{{ asset('storage/' . $path) }}" alt="{{ $product->title ?? 'Product' }}"
                                                class="w-100 h-100 object-fit-cover" loading="lazy"
                                                onerror="this.onerror=null; this.src='{{ $dummyImage }}';">
                                        @else
                                             <img src="{{ $dummyImage }}" alt="{{ $product->title ?? 'Product' }}"
                                                class="w-100 h-100 object-fit-cover">
                                        @endif
                                    </a>
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
                        $path = $firstImage->path ?? $firstImage->image ?? null;
                    @endphp
                    <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="d-block w-100 h-100">
                        @if($path)
                            <img src="{{ asset('storage/' . $path) }}" alt="{{ $product->title ?? 'Product' }}"
                                class="w-100 h-100 object-fit-cover" loading="lazy"
                                onerror="this.onerror=null; this.src='{{ $dummyImage }}';">
                        @else
                            <img src="{{ $dummyImage }}" alt="{{ $product->title ?? 'Product' }}"
                                class="w-100 h-100 object-fit-cover">
                        @endif
                    </a>
                @endif

            </div>

            <div class="position-absolute top-0 start-0 p-2 d-flex flex-wrap gap-1" style="z-index: 2; pointer-events: none;">
                @if($isNew)
                    <span class="badge bg-primary">New</span>
                @endif
                @if($isOnSale && $discountPercent > 0)
                    <span class="badge bg-danger">-{{ $discountPercent }}%</span>
                @endif
                @if($product->featured ?? false)
                    <span class="badge bg-warning text-dark">Hot</span>
                @endif
            </div>

            @if(!$inStock)
                <div class="position-absolute bottom-0 start-0 end-0 text-center py-2"
                    style="background: rgba(220, 53, 69, 0.9); z-index: 2;">
                    <span class="text-white fw-bold small">Out of Stock</span>
                </div>
            @endif
        </div>

        <div class="property-single-content">
            <h4 class="title-animation">
                <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                    {{ Str::limit($product->title ?? 'Product', 40) }}
                </a>
            </h4>
            <p class="m-0"><i class='bx bxs-tag me-1'></i>{{ $categoryName }}</p>
        </div>

        <div class="property-details">
            <ul class="d-flex align-items-center">
                <li class="w-50">
                    <i class='bx bx-coin-stack me-1'></i>
                    @if($isOnSale)
                        <span class="text-danger fw-bold">৳{{ number_format($salePrice, 0) }}</span>
                        <small class="text-decoration-line-through text-muted ms-1">৳{{ number_format($price, 0) }}</small>
                    @else
                        <span class="fw-bold">৳{{ number_format($price, 0) }}</span>
                    @endif
                </li>
                <li class="w-50">
                    <i class='bx bx-package me-1'></i>
                    @if($inStock)
                        <span class="text-success">In Stock</span>
                    @else
                        <span class="text-danger">Out of Stock</span>
                    @endif
                </li>
            </ul>
        </div>

        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}"
                class="action-btn-success p-3 h-30px w-auto rounded-3">
                <i class="bx bx-show fs-15 me-1"></i>View
            </a>
            <button type="button" title="Add to Wishlist" data-id="{{ $product->id }}"
                class="add-to-wishlist action-btn-danger p-3 ms-2 h-30px w-30px rounded-5 border-0">
                <i class="bx bxs-heart fs-20"></i>
            </button>
            @if($inStock)
                <button type="button" title="Add to Cart" data-id="{{ $product->id }}"
                    class="add-to-cart action-btn-success p-3 ms-2 h-30px w-auto rounded-3 border-0">
                    <i class="bx bxs-cart fs-15 me-1"></i>Cart
                </button>
            @endif
        </div>
    </div>
</div>