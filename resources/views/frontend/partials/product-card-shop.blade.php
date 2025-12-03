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

    // Check if new (within 30 days)
    $isNew = $product->created_at && $product->created_at->diffInDays(now()) < 30;
    
    // Dummy images array for fallback
    $dummyImages = [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop',
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop',
        'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop',
        'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=400&h=400&fit=crop',
        'https://images.unsplash.com/photo-1560343090-f0409e92791a?w=400&h=400&fit=crop',
    ];
    $randomDummyImage = $dummyImages[array_rand($dummyImages)];
@endphp

<div class="col-12 col-sm-6 col-md-4 col-lg-4">
    <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
        <div class="property-list-img-area position-relative">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                <div class="img1 image-anime">
                    @if($productImage)
                        <img src="{{ asset('storage/' . $productImage) }}" 
                             alt="{{ $product->title ?? 'Product' }}"
                             onerror="this.src='{{ $randomDummyImage }}'">
                    @else
                        <img src="{{ $randomDummyImage }}" alt="{{ $product->title ?? 'Product' }}">
                    @endif
                </div>
            </a>
            
            <div class="position-absolute top-0 start-0 p-2 d-flex flex-wrap gap-1">
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
            <div class="position-absolute bottom-0 start-0 end-0 text-center py-2" style="background: rgba(220, 53, 69, 0.9);">
                <span class="text-white fw-bold small">Out of Stock</span>
            </div>
            @endif
        </div>
        
        <div class="property-single-content">
            <h4 class="title-animation">
                <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                    {{ Str::limit($product->title ?? 'Product', 35) }}
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
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="action-btn-success p-3 h-30px w-auto rounded-3">
                <i class="bx bx-show fs-15 me-1"></i>View
            </a>
            <button type="button" 
                    title="Add to Wishlist" 
                    data-id="{{ $product->id }}" 
                    class="add-to-wishlist action-btn-danger p-3 ms-2 h-30px w-30px rounded-5 border-0">
                <i class="bx bxs-heart fs-20"></i>
            </button>
            @if($inStock)
                <button type="button" 
                        title="Add to Cart" 
                        data-id="{{ $product->id }}" 
                        class="add-to-cart action-btn-success p-3 ms-2 h-30px w-auto rounded-3 border-0">
                    <i class="bx bxs-cart fs-15 me-1"></i>Cart
                </button>
            @endif
        </div>
    </div>
</div>
