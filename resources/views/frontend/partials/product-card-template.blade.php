@php
    // Get product image path
    $productImagePath = null;
    
    // Try coverImage relationship first
    if ($product->coverImage && $product->coverImage->path) {
        $productImagePath = $product->coverImage->path;
    }
    // Try images collection
    elseif ($product->images && $product->images->count() > 0) {
        $coverImg = $product->images->where('is_cover', true)->first();
        if ($coverImg && $coverImg->path) {
            $productImagePath = $coverImg->path;
        } else {
            $firstImg = $product->images->first();
            if ($firstImg && $firstImg->path) {
                $productImagePath = $firstImg->path;
            }
        }
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
    }

    // Check if new (within 30 days)
    $isNew = $product->created_at && $product->created_at->diffInDays(now()) < 30;
    
    // Dummy images for fallback
    $dummyImageList = ['KHPP-SA21 - 1.png', 'KHPP-SA22 - 1.png', 'KHPP-SA23 - 1.png', 'KHPP-SA24 - 1.png'];
    $dummyImage = 'frontend/assets/images/shop/' . $dummyImageList[array_rand($dummyImageList)];
@endphp

<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
        <div class="property-list-img-area position-relative" style="aspect-ratio: 1; background: #f8f9fa;">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="d-block h-100">
                <div class="img1 h-100" style="overflow: hidden;">
                    @if($productImagePath)
                        <img src="{{ asset('storage/' . $productImagePath) }}" 
                             alt="{{ $product->title ?? 'Product' }}"
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset($dummyImage) }}';">
                    @else
                        <img src="{{ asset($dummyImage) }}" 
                             alt="{{ $product->title ?? 'Product' }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
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
