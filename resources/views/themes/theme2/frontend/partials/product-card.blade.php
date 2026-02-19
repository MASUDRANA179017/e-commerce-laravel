<div class="product-card-theme2 h-100">
    @once
    <style>
        .product-card-theme2 {
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            transition: all 0.3s ease;
        }
        .product-card-theme2:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transform: translateY(-3px);
            border-color: var(--primary-red);
        }
        .btn-area1 {
            gap: 5px;
            margin-top: 15px !important;
        }
        .btn-area1 .btn-view {
            background: var(--dark-red); /* Theme 2 Secondary */
            color: #fff !important;
            font-size: 13px;
            padding: 0 12px;
            border-radius: 4px;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            height: 36px;
            transition: all 0.3s ease;
        }
        .btn-area1 .btn-wishlist {
            background: #dc3545; /* Bootstrap Danger */
            color: #fff !important;
            width: 36px;
            height: 36px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-area1 .btn-cart {
            background: var(--primary-red); /* Theme 2 Primary */
            color: #fff !important;
            font-size: 13px;
            padding: 0 12px;
            border-radius: 4px;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            height: 36px;
            transition: all 0.3s ease;
        }
        .btn-area1 .btn-cart:hover, .btn-area1 .btn-view:hover, .btn-area1 .btn-wishlist:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .img-wrapper {
            position: relative;
            padding-top: 100%; /* 1:1 Aspect Ratio */
            overflow: hidden;
            background-color: #f9f9f9;
        }
        .img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cover ensures full width/height usage without distortion */
            transition: transform 0.5s ease;
        }
        .product-card-theme2:hover .img-wrapper img {
            transform: scale(1.08);
        }
        .content-wrapper {
            padding: 15px;
        }
        .title {
            font-size: 15px;
            font-weight: 600;
            color: #2b2b2b;
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 42px;
        }
        .title:hover {
            color: var(--primary-red);
        }
    </style>
    @endonce

    @php
        $image = $product->cover_image;
        if (!$image && isset($product->images) && $product->images->count() > 0) {
            $firstImage = $product->images->first();
            $image = $firstImage->path ?? $firstImage->image ?? null;
        }
        $imageUrl = $image ? asset('storage/' . $image) : asset('frontend/assets/images/no-image.png');

        $price = $product->effective_price ?? ($product->price ?? 0);
        $salePrice = $product->sale_price ?? null;

        $flashSalePrice = null;
        $flashDiscountPercent = 0;
        $isFlashSale = false;

        if (method_exists($product, 'getActiveFlashSaleAttribute')) {
            $activeFlashSale = $product->active_flash_sale;
            if ($activeFlashSale) {
                $flashSalePrice = $activeFlashSale->pivot->flash_price ?? null;
                $flashDiscountPercent = $activeFlashSale->pivot->flash_discount_percent ?? 0;

                if ($flashDiscountPercent <= 0 && (!$flashSalePrice || $flashSalePrice <= 0)) {
                    $flashDiscountPercent = $activeFlashSale->discount_percent ?? 0;
                }

                if ((!$flashSalePrice || $flashSalePrice <= 0) && $flashDiscountPercent > 0) {
                    $flashSalePrice = $price - ($price * ($flashDiscountPercent / 100));
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

        $priceRange = null;
        $hasVariants = false;
        $rawPriceRange = null;

        if (isset($product->variants) && $product->variants->count() > 0) {
            $priceRange = $product->formatted_price_range ?? null;
            $rawPriceRange = $product->price_range ?? null;
            $hasVariants = true;
        }

        $wishlistItems = session()->get('wishlist', []);
        $wishlistProductIds = array_keys($wishlistItems);
        $hasInWishList = in_array($product->id, $wishlistProductIds);
    @endphp

    <div class="img-wrapper position-relative">
        <a href="{{ route('product.show', $product->slug) }}">
            <img src="{{ $imageUrl }}" alt="{{ $product->title }}">
        </a>

        @if($isOnSale)
            <div class="top-0 px-3 m-2 position-absolute start-0 badge bg-danger rounded-pill">
                -{{ $discountPercent }}%
            </div>
        @endif
    </div>

    <div class="content-wrapper">
        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
            <h3 class="title" title="{{ $product->title }}">{{ $product->title }}</h3>
        </a>

        <div class="mb-2 d-flex justify-content-between align-items-center">
            <div class="price-box">
                @if($hasVariants && $priceRange)
                    @if($isFlashSale && $rawPriceRange)
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
                            <span class="text-danger fw-bold fs-16">
                                @if ($finalMin == $finalMax)
                                    ৳{{ number_format($finalMin, 0) }}
                                @else
                                    ৳{{ number_format($finalMin, 0) }} - ৳{{ number_format($finalMax, 0) }}
                                @endif
                            </span>
                        @else
                            <span class="text-danger fw-bold fs-16">{{ $priceRange }}</span>
                        @endif
                    @else
                        <span class="text-danger fw-bold fs-16">{{ $priceRange }}</span>
                    @endif
                @elseif($isOnSale)
                    <span class="text-decoration-line-through text-muted fs-13">৳{{ number_format($originalPrice, 0) }}</span>
                    <span class="text-danger fw-bold ms-1 fs-16">৳{{ number_format($finalPrice, 0) }}</span>
                @else
                    <span class="text-danger fw-bold fs-16">৳{{ number_format($price, 0) }}</span>
                @endif
            </div>
        </div>

        <div class="btn-area1 d-flex">
            <a href="{{ route('product.show', $product->slug) }}" class="btn-view">
                <i class="fa-solid fa-eye me-1"></i> View
            </a>

            @if($hasVariants)
                <button type="button" class="btn-cart" onclick="openQuickView({{ $product->id }}); return false;">
                    <i class="fa-solid fa-cart-shopping me-1"></i> Add
                </button>
            @else
                <button type="button" class="btn-cart add-to-cart" data-id="{{ $product->id }}">
                    <i class="fa-solid fa-cart-shopping me-1"></i> Add
                </button>
            @endif

            <a href="javascript:void(0)" class="btn-wishlist add-to-wishlist" data-id="{{ $product->id }}" data-has-in-wishlist="{{ $hasInWishList ? 'true' : 'false' }}">
                <i class="{{ $hasInWishList ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
            </a>
        </div>
    </div>
</div>
