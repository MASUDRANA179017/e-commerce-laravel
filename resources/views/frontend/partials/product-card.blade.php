@php
    // Fallback dummy image
    $dummyImage = asset('frontend/assets/images/shop/KHPP-SA21 - 1.png');
    
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

    // Check if new
    $isNew = $product->created_at && $product->created_at->diffInDays(now()) < 30;
@endphp

<div class="product-card-wrapper">
    <div class="product-card">
        <!-- Product Image Container -->
        <div class="product-card__image">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="product-link">
                @if($productImage)
                    <img src="{{ asset('storage/' . $productImage) }}" 
                         alt="{{ $product->title ?? 'Product' }}"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ $dummyImage }}';">
                @else
                    <img src="{{ $dummyImage }}" 
                         alt="{{ $product->title ?? 'Product' }}">
                @endif
            </a>
            
            <!-- Badges -->
            <div class="product-card__badges">
                @if($isOnSale)
                    <span class="badge badge--sale">-{{ $discountPercent }}%</span>
                @endif
                @if($isNew)
                    <span class="badge badge--new">New</span>
                @endif
                @if($product->featured ?? false)
                    <span class="badge badge--featured"><i class="fa-solid fa-star"></i></span>
                @endif
            </div>
            
            <!-- Quick Actions -->
            <div class="product-card__actions">
                <button class="action-btn add-to-wishlist" 
                        data-product-id="{{ $product->id }}" 
                        title="Add to Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <a href="{{ route('product.show', $product->slug ?? $product->id) }}" 
                   class="action-btn" 
                   title="Quick View">
                    <i class="fa-regular fa-eye"></i>
                </a>
                <button class="action-btn add-to-cart" 
                        data-product-id="{{ $product->id }}"
                        title="Add to Cart"
                        {{ !$inStock ? 'disabled' : '' }}>
                    <i class="fa-solid fa-cart-plus"></i>
                </button>
            </div>

            <!-- Out of Stock Overlay -->
            @if(!$inStock)
            <div class="product-card__out-of-stock">
                <span>Out of Stock</span>
            </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div class="product-card__info">
            <!-- Category -->
            <div class="product-card__category">
                {{ $categoryName }}
                @if($brandName)
                    <span class="separator">•</span>
                    <span class="brand">{{ $brandName }}</span>
                @endif
            </div>
            
            <!-- Title -->
            <h3 class="product-card__title">
                <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                    {{ Str::limit($product->title ?? 'Product', 50) }}
                </a>
            </h3>
            
            <!-- Rating (Static for now) -->
            <div class="product-card__rating">
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star {{ $i <= 4 ? 'filled' : '' }}"></i>
                    @endfor
                </div>
                <span class="rating-count">({{ rand(10, 150) }})</span>
            </div>
            
            <!-- Price -->
            <div class="product-card__price">
                @if($isOnSale)
                    <span class="current-price">৳{{ number_format($salePrice, 0) }}</span>
                    <span class="original-price">৳{{ number_format($price, 0) }}</span>
                @else
                    <span class="current-price">৳{{ number_format($price, 0) }}</span>
                @endif
            </div>
            
            <!-- Add to Cart Button -->
            <button class="product-card__add-btn add-to-cart" 
                    data-product-id="{{ $product->id }}"
                    {{ !$inStock ? 'disabled' : '' }}>
                @if($inStock)
                    <i class="fa-solid fa-shopping-bag"></i>
                    <span>Add to Cart</span>
                @else
                    <i class="fa-solid fa-ban"></i>
                    <span>Out of Stock</span>
                @endif
            </button>
        </div>
    </div>
</div>

<style>
/* Product Card Wrapper */
.product-card-wrapper {
    height: 100%;
}

/* Product Card */
.product-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid #f0f0f0;
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(4, 150, 255, 0.15);
    border-color: rgba(4, 150, 255, 0.2);
}

/* Product Image */
.product-card__image {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    aspect-ratio: 1;
}

.product-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.product-card:hover .product-card__image img {
    transform: scale(1.1);
}

/* Badges */
.product-card__badges {
    position: absolute;
    top: 15px;
    left: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 2;
}

.product-card__badges .badge {
    padding: 6px 12px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge--sale {
    background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
    color: #fff;
}

.badge--new {
    background: linear-gradient(135deg, #0496ff 0%, #00d4aa 100%);
    color: #fff;
}

.badge--featured {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: #fff;
    padding: 6px 8px !important;
}

/* Quick Actions */
.product-card__actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
    z-index: 2;
}

.product-card:hover .product-card__actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #555;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.action-btn:hover {
    background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
    color: #fff;
    transform: scale(1.1);
}

.action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.action-btn.add-to-wishlist.active,
.action-btn.add-to-wishlist:hover {
    background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
}

.action-btn.add-to-wishlist.active i,
.action-btn.add-to-wishlist:hover i {
    color: #fff;
}

/* Out of Stock Overlay */
.product-card__out-of-stock {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(26, 26, 46, 0.9);
    color: #fff;
    text-align: center;
    padding: 12px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Product Info */
.product-card__info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

/* Category */
.product-card__category {
    font-size: 12px;
    color: #888;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.product-card__category .separator {
    color: #ddd;
}

.product-card__category .brand {
    color: #0496ff;
    font-weight: 600;
}

/* Title */
.product-card__title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
    line-height: 1.4;
}

.product-card__title a {
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.3s;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-card__title a:hover {
    color: #0496ff;
}

/* Rating */
.product-card__rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.product-card__rating .stars {
    display: flex;
    gap: 2px;
}

.product-card__rating .stars i {
    font-size: 12px;
    color: #ddd;
}

.product-card__rating .stars i.filled {
    color: #ffc107;
}

.product-card__rating .rating-count {
    font-size: 12px;
    color: #888;
}

/* Price */
.product-card__price {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    margin-top: auto;
}

.product-card__price .current-price {
    font-size: 22px;
    font-weight: 700;
    color: #0496ff;
}

.product-card__price .original-price {
    font-size: 15px;
    color: #999;
    text-decoration: line-through;
}

/* Add Button */
.product-card__add-btn {
    width: 100%;
    padding: 14px 20px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.product-card__add-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(4, 150, 255, 0.3);
}

.product-card__add-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.product-card__add-btn i {
    font-size: 16px;
}

/* Loading State */
.product-card__add-btn.loading {
    pointer-events: none;
}

.product-card__add-btn.loading span {
    display: none;
}

.product-card__add-btn.loading::after {
    content: '';
    width: 20px;
    height: 20px;
    border: 2px solid #fff;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 576px) {
    .product-card__image {
        aspect-ratio: 4/3;
    }
    
    .product-card__info {
        padding: 15px;
    }
    
    .product-card__title {
        font-size: 14px;
    }
    
    .product-card__price .current-price {
        font-size: 18px;
    }
    
    .product-card__add-btn {
        padding: 12px 16px;
        font-size: 13px;
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
    }
}
</style>
