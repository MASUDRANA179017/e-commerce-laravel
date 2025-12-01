<div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
    <div class="property-list-img-area position-relative">
        <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
            <div class="img1 image-anime">
                @if($product->images && $product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->title ?? $product->name ?? 'Product' }}">
                @elseif($product->coverImage)
                    <img src="{{ asset('storage/' . $product->coverImage->image) }}" alt="{{ $product->title ?? $product->name ?? 'Product' }}">
                @else
                    <img src="https://via.placeholder.com/300x280?text=No+Image" alt="{{ $product->title ?? $product->name ?? 'Product' }}">
                @endif
            </div>
        </a>
        <div class="position-absolute top-0 start-0 p-2">
            @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                <span class="badge bg-primary me-1">New</span>
            @endif
            @if($product->featured ?? false)
                <span class="badge bg-warning text-dark">Featured</span>
            @endif
        </div>
        <div class="position-absolute top-0 end-0 p-2">
            <button class="btn btn-light btn-sm rounded-circle add-to-wishlist shadow-sm" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                <i class='bx bx-heart'></i>
            </button>
        </div>
    </div>
    <div class="property-single-content">
        <h4 class="title-animation">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}">{{ Str::limit($product->title ?? $product->name ?? 'Product', 40) }}</a>
        </h4>
        <p class="m-0">
            <i class='bx bxs-tag me-1'></i>
            @if($product->categories && $product->categories->count() > 0)
                {{ $product->categories->first()->name }}
            @elseif($product->category)
                {{ $product->category->name }}
            @else
                Uncategorized
            @endif
        </p>
    </div>
    <div class="property-details">
        <ul class="d-flex align-items-center">
            <li class="w-50">
                <i class='bx bx-coin-stack me-1'></i>
                @php
                    // Get price from variants if available
                    $price = 0;
                    $salePrice = null;
                    if ($product->variants && $product->variants->count() > 0) {
                        $variant = $product->variants->first();
                        $price = $variant->price ?? 0;
                        $salePrice = $variant->sale_price ?? null;
                    } elseif (isset($product->price)) {
                        $price = $product->price;
                        $salePrice = $product->sale_price ?? null;
                    }
                @endphp
                @if($salePrice && $salePrice < $price)
                    <span class="text-danger fw-bold">${{ number_format($salePrice, 2) }}</span>
                    <small class="text-muted text-decoration-line-through ms-1">${{ number_format($price, 2) }}</small>
                @else
                    <span class="fw-bold">${{ number_format($price, 2) }}</span>
                @endif
            </li>
            <li class="w-50 text-end">
                <i class='bx bx-package me-1'></i>
                @php
                    $stock = 0;
                    if ($product->variants && $product->variants->count() > 0) {
                        $stock = $product->variants->sum('stock') ?? 0;
                    } elseif (isset($product->stock)) {
                        $stock = $product->stock;
                    }
                @endphp
                @if($stock > 0)
                    <span class="text-success">In Stock</span>
                @else
                    <span class="text-danger">Out of Stock</span>
                @endif
            </li>
        </ul>
    </div>
    <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
        <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="action-btn-success p-2 px-3 rounded-3 text-decoration-none">
            <i class="bx bx-show me-1"></i>View
        </a>
        <button class="action-btn-danger p-2 ms-2 rounded-circle add-to-wishlist" data-product-id="{{ $product->id }}" title="Add to Wishlist">
            <i class="bx bxs-heart"></i>
        </button>
        <button class="action-btn-success p-2 px-3 ms-2 rounded-3 add-to-cart" 
                data-product-id="{{ $product->id }}" 
                {{ $stock <= 0 ? 'disabled' : '' }}
                title="Add to Cart">
            <i class="bx bxs-cart me-1"></i>Cart
        </button>
    </div>
</div>
