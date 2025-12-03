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
    
    // Get additional images for carousel
    $additionalImages = [];
    if ($product->images && $product->images->count() > 1) {
        $additionalImages = $product->images->take(3);
    }

    // Get price
    $price = $product->price ?? 0;
    $salePrice = $product->sale_price ?? null;
    $isOnSale = $salePrice && $salePrice < $price;

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
@endphp

<div class="col-12 col-sm-6 col-md-4 col-lg-4">
    <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
        <div class="property-list-img-area position-relative owl-carousel">
            @if($additionalImages && count($additionalImages) > 0)
                @foreach($additionalImages as $img)
                    <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                        <div class="img1 image-anime">
                            <img src="{{ asset('storage/' . ($img->path ?? $img->image)) }}" alt="{{ $product->title ?? 'Product' }}">
                        </div>
                    </a>
                @endforeach
            @else
                <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                    <div class="img1 image-anime">
                        @if($productImage)
                            <img src="{{ asset('storage/' . $productImage) }}" alt="{{ $product->title ?? 'Product' }}">
                        @else
                            <img src="https://via.placeholder.com/400x400/f8f9fa/6c757d?text=No+Image" alt="{{ $product->title ?? 'Product' }}">
                        @endif
                    </div>
                </a>
            @endif
            
            <div class="position-absolute top-0 start-0 p-2">
                @if($isNew)
                    <span class="badge bg-primary me-1">New</span>
                @endif
                @if($isOnSale)
                    <span class="badge bg-warning">Sale</span>
                @endif
                @if($product->featured ?? false)
                    <span class="badge bg-success me-1">Featured</span>
                @endif
                @if(!$inStock)
                    <span class="badge bg-danger">Out of Stock</span>
                @endif
            </div>
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

