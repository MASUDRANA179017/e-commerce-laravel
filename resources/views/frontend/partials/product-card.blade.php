@php
    // Get product image
    $productImage = null;
    if (isset($product->cover_image) && $product->cover_image) {
        $productImage = $product->cover_image;
    } elseif ($product->images && $product->images->count() > 0) {
        $img = $product->images->where('is_cover', true)->first() ?? $product->images->first();
        $productImage = $img->path ?? $img->image ?? null;
    } elseif (isset($product->coverImage) && $product->coverImage) {
        $productImage = $product->coverImage->path ?? $product->coverImage->image ?? null;
    }

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
    } elseif (isset($product->category_name)) {
        $categoryName = $product->category_name;
    }

    // Get brand
    $brandName = null;
    if (isset($product->brand) && $product->brand) {
        $brandName = $product->brand->name ?? null;
    } elseif (isset($product->brand_name)) {
        $brandName = $product->brand_name;
    }
@endphp

<div class="product-card bg-white rounded-4 shadow-sm overflow-hidden h-100" data-aos="fade-up" data-aos-duration="800">
    <!-- Product Image -->
    <div class="product-image position-relative">
        <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
            @if($productImage)
                <img src="{{ asset('storage/' . $productImage) }}" 
                     alt="{{ $product->title ?? 'Product' }}" 
                     class="img-fluid w-100" 
                     style="height: 250px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/300x250?text=No+Image'">
            @else
                <img src="https://via.placeholder.com/300x250?text=No+Image" 
                     alt="{{ $product->title ?? 'Product' }}" 
                     class="img-fluid w-100" 
                     style="height: 250px; object-fit: cover;">
            @endif
        </a>
        
        <!-- Badges -->
        <div class="product-badges position-absolute top-0 start-0 p-2 d-flex flex-column gap-1">
            @if($isOnSale)
                <span class="badge bg-danger">-{{ $discountPercent }}%</span>
            @endif
            @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                <span class="badge bg-primary">New</span>
            @endif
            @if($product->featured ?? false)
                <span class="badge bg-warning text-dark">Featured</span>
            @endif
        </div>
        
        <!-- Quick Actions -->
        <div class="product-actions position-absolute top-0 end-0 p-2 d-flex flex-column gap-1">
            <button class="btn btn-light btn-sm rounded-circle shadow-sm add-to-wishlist" 
                    data-product-id="{{ $product->id }}" 
                    title="Add to Wishlist">
                <i class="fa-regular fa-heart"></i>
            </button>
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" 
               class="btn btn-light btn-sm rounded-circle shadow-sm" 
               title="Quick View">
                <i class="fa-regular fa-eye"></i>
            </a>
        </div>

        <!-- Stock Badge -->
        @if(!$inStock)
        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white text-center py-2">
            <small><i class="fa-solid fa-exclamation-circle me-1"></i>Out of Stock</small>
        </div>
        @endif
    </div>
    
    <!-- Product Info -->
    <div class="product-info p-3">
        <!-- Category & Brand -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="text-muted">
                <i class="fa-solid fa-folder me-1"></i>{{ $categoryName }}
            </small>
            @if($brandName)
            <small class="text-primary fw-medium">{{ $brandName }}</small>
            @endif
        </div>
        
        <!-- Title -->
        <h6 class="product-title mb-2">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" 
               class="text-dark text-decoration-none" 
               title="{{ $product->title ?? 'Product' }}">
                {{ Str::limit($product->title ?? 'Product', 45) }}
            </a>
        </h6>
        
        <!-- Price -->
        <div class="product-price mb-3">
            @if($isOnSale)
                <span class="text-danger fw-bold fs-5">৳{{ number_format($salePrice, 0) }}</span>
                <small class="text-muted text-decoration-line-through ms-2">৳{{ number_format($price, 0) }}</small>
            @else
                <span class="text-primary fw-bold fs-5">৳{{ number_format($price, 0) }}</span>
            @endif
        </div>
        
        <!-- Add to Cart -->
        <div class="product-actions-bottom d-flex gap-2">
            <button class="btn btn-primary flex-grow-1 add-to-cart" 
                    data-product-id="{{ $product->id }}"
                    {{ !$inStock ? 'disabled' : '' }}>
                <i class="fa-solid fa-cart-plus me-1"></i>
                {{ $inStock ? 'Add to Cart' : 'Out of Stock' }}
            </button>
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" 
               class="btn btn-outline-secondary">
                <i class="fa-solid fa-eye"></i>
            </a>
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12) !important;
    }
    .product-card .product-image {
        overflow: hidden;
    }
    .product-card .product-image img {
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-image img {
        transform: scale(1.08);
    }
    .product-card .product-actions {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .product-card:hover .product-actions {
        opacity: 1;
    }
    .product-card .product-title a:hover {
        color: #0496ff !important;
    }
    .product-card .btn-primary {
        background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
        border: none;
    }
    .product-card .btn-primary:hover {
        background: linear-gradient(135deg, #0380d9 0%, #026bb8 100%);
    }
</style>
