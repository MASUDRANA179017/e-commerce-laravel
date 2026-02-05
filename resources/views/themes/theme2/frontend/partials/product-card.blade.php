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

    <div class="img-wrapper position-relative">
        <a href="{{ route('product.show', $product->slug) }}">
            @php
                $image = $product->cover_image;
                if (!$image && $product->images->count() > 0) {
                    $image = $product->images->first()->path ?? $product->images->first()->image;
                }
                $imageUrl = $image ? asset('storage/' . $image) : asset('frontend/assets/images/no-image.png');

                // Calculate discount price
                $sellingPrice = $product->price;
                if($product->discount_price > 0) {
                    if($product->discount_type == 'percent') {
                        $sellingPrice = $product->price - ($product->price * $product->discount_price / 100);
                    } else {
                        $sellingPrice = $product->price - $product->discount_price;
                    }
                }

                // Wishlist check
                $wishlistItems = session()->get('wishlist', []);
                $wishlistProductIds = array_keys($wishlistItems);
                $hasInWishList = in_array($product->id, $wishlistProductIds);
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $product->title }}">
        </a>

        <!-- Discount Badge -->
        @if($product->discount_price > 0)
            <div class="top-0 px-3 m-2 position-absolute start-0 badge bg-danger rounded-pill">
                -{{ $product->discount_type == 'percent' ? $product->discount_price . '%' : '৳' . $product->discount_price }}
            </div>
        @endif
    </div>

    <div class="content-wrapper">
        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
            <h3 class="title" title="{{ $product->title }}">{{ $product->title }}</h3>
        </a>

        <div class="mb-2 d-flex justify-content-between align-items-center">
            <div class="price-box">
                @if($product->discount_price > 0)
                    <span class="text-decoration-line-through text-muted fs-13">৳{{ $product->price }}</span>
                    <span class="text-danger fw-bold ms-1 fs-16">৳{{ number_format($sellingPrice, 2) }}</span>
                @else
                    <span class="text-danger fw-bold fs-16">৳{{ $product->price }}</span>
                @endif
            </div>
        </div>

        <div class="btn-area1 d-flex">
            <a href="{{ route('product.show', $product->slug) }}" class="btn-view">
                <i class="fa-solid fa-eye me-1"></i> View
            </a>

            <button type="button" class="btn-cart add-to-cart" data-id="{{ $product->id }}">
                 <i class="fa-solid fa-cart-shopping me-1"></i> Add
            </button>

            <a href="javascript:void(0)" class="btn-wishlist add-to-wishlist" data-id="{{ $product->id }}" data-has-in-wishlist="{{ $hasInWishList ? 'true' : 'false' }}">
                 <i class="{{ $hasInWishList ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
            </a>
        </div>
    </div>
</div>
