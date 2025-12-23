@php
    $cart = session()->get('cart', []);
    $cartCount = 0;
    $cartSubtotal = 0;
    foreach ($cart as $item) {
        $cartCount += $item['qty'] ?? 1;
        $cartSubtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
    }
@endphp

<!-- Cart Overlay -->
<div id="cartOverlay" class="cart-overlay" onclick="closeSidebarCart()"></div>

<!-- Sidebar Cart -->
<div id="sidebarCart" class="sidebar-cart">
    
    <!-- Cart Header -->
    <div class="sidebar-cart-header">
        <div class="d-flex align-items-center">
            <div class="cart-icon-box">
                <i class="fa-solid fa-shopping-bag"></i>
            </div>
            <div>
                <h5 class="mb-0 text-white fw-semibold">Shopping Cart</h5>
                <small class="cart-items-count">{{ $cartCount }} {{ $cartCount == 1 ? 'Item' : 'Items' }}</small>
            </div>
        </div>
        <button type="button" onclick="closeSidebarCart()" class="close-cart-btn" aria-label="Close cart">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <!-- Cart Items -->
    <div class="sidebar-cart-body">
        @if(count($cart) > 0)
        <div class="cart-items-list">
            @foreach($cart as $rowId => $item)
            <div class="sidebar-cart-item" data-row-id="{{ $rowId }}" data-product-id="{{ $item['id'] }}">
                <div class="cart-item-img">
                    @php
                        $cartItemImage = $item['options']['image'] ?? null;
                        $cartDummyImage = 'frontend/assets/images/shop/KHPP-SA21 - 1.png';
                    @endphp
                    @if($cartItemImage)
                        <img src="{{ asset('storage/' . $cartItemImage) }}" alt="{{ $item['name'] }}" onerror="this.onerror=null; this.src='{{ asset($cartDummyImage) }}';">
                    @else
                        <img src="{{ asset($cartDummyImage) }}" alt="{{ $item['name'] }}">
                    @endif
                </div>
                <div class="cart-item-info">
                    <h6 class="cart-item-title">
                        <a href="{{ route('product.show', $item['options']['slug'] ?? $item['id']) }}">
                            {{ Str::limit($item['name'], 28) }}
                        </a>
                    </h6>
                    @if(!empty($item['options']['variant']))
                        <small class="text-muted d-block mb-1">Variant: {{ $item['options']['variant'] }}</small>
                    @endif
                    <div class="cart-item-price">
                        <span class="price">৳{{ number_format($item['price'], 0) }}</span>
                        <span class="multiply">×</span>
                        <span class="qty">{{ $item['qty'] }}</span>
                        <span class="total">= ৳{{ number_format($item['price'] * $item['qty'], 0) }}</span>
                    </div>
                    <div class="cart-item-actions">
                        <div class="qty-selector">
                            <button type="button" class="qty-btn" onclick="updateCartQty('{{ $rowId }}', -1)">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <span class="qty-value" id="qty-{{ $rowId }}">{{ $item['qty'] }}</span>
                            <button type="button" class="qty-btn" onclick="updateCartQty('{{ $rowId }}', 1)">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <div class="variant-selector">
                            <button type="button" class="qty-btn" onclick="openVariantSelector('{{ $rowId }}')"
                                title="Change Variant">
                                <i class="fa-solid fa-sliders"></i>
                            </button>
                        </div>
                        <button type="button" class="remove-btn" onclick="removeFromCart('{{ $rowId }}')" title="Remove">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="variant-select-wrap mt-2" style="display:none;">
                        <select class="form-select form-select-sm variant-select"></select>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="applyVariantChange('{{ $rowId }}')">Apply</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h5>Your cart is empty</h5>
            <p>Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn-shop-now">
                <i class="fa-solid fa-bag-shopping me-2"></i> Start Shopping
            </a>
        </div>
        @endif
    </div>
    
    <!-- Cart Footer -->
    @if(count($cart) > 0)
    <div class="sidebar-cart-footer">
        <div class="cart-subtotal">
            <span>Subtotal:</span>
            <span class="subtotal-amount">৳{{ number_format($cartSubtotal, 0) }}</span>
        </div>
        
        <p class="shipping-note">
            @if($cartSubtotal >= 5000)
                <i class="fa-solid fa-circle-check text-success me-1"></i> You qualify for <strong>FREE shipping</strong>!
            @else
                <i class="fa-solid fa-truck me-1"></i> Add ৳{{ number_format(5000 - $cartSubtotal, 0) }} more for <strong>FREE shipping</strong>
            @endif
        </p>
        
        <div class="cart-buttons">
            <a href="{{ route('cart.index') }}" class="btn-view-cart">
                <i class="fa-solid fa-cart-shopping me-2"></i> View Cart
            </a>
            <a href="{{ route('checkout.index') }}" class="btn-checkout">
                <i class="fa-solid fa-lock me-2"></i> Checkout
            </a>
        </div>
    </div>
    @endif
</div>

<style>
/* Cart Overlay */
#cartOverlay {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: rgba(0, 0, 0, 0.6) !important;
    z-index: 99998 !important;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease !important;
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
}
#cartOverlay.active {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Sidebar Cart */
#sidebarCart {
    position: fixed !important;
    top: 0 !important;
    right: -450px !important;
    width: 420px !important;
    max-width: 95vw !important;
    height: 100vh !important;
    height: 100dvh !important;
    background: #fff !important;
    z-index: 99999 !important;
    display: flex !important;
    flex-direction: column !important;
    transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15) !important;
    transform: translateZ(0);
    -webkit-transform: translateZ(0);
}
#sidebarCart.active {
    right: 0 !important;
}

/* Cart Header */
.sidebar-cart-header {
    padding: 20px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.cart-icon-box {
    width: 42px;
    height: 42px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    color: #fff;
    font-size: 18px;
}
.cart-items-count {
    color: rgba(255, 255, 255, 0.7);
    font-size: 13px;
}
.close-cart-btn {
    width: 38px;
    height: 38px;
    border: none;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.close-cart-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: rotate(90deg);
}

/* Cart Body */
.sidebar-cart-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
}

/* Cart Item */
.sidebar-cart-item {
    display: flex;
    gap: 15px;
    padding: 15px;
    margin-bottom: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s;
}
.sidebar-cart-item:hover {
    background: #f0f0f0;
}
.cart-item-img {
    width: 75px;
    height: 75px;
    flex-shrink: 0;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}
.cart-item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cart-item-info {
    flex: 1;
    min-width: 0;
}
.cart-item-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
    line-height: 1.4;
}
.cart-item-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}
.cart-item-title a:hover {
    color: #0496ff;
}
.cart-item-price {
    font-size: 13px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
}
.cart-item-price .price {
    color: #0496ff;
    font-weight: 600;
}
.cart-item-price .multiply {
    color: #ccc;
}
.cart-item-price .qty {
    color: #666;
}
.cart-item-price .total {
    color: #28a745;
    font-weight: 600;
}
.cart-item-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.qty-selector {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e0e0e0;
}
.qty-btn {
    width: 30px;
    height: 30px;
    border: none;
    background: transparent;
    color: #333;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
}
.qty-btn:hover {
    background: #f0f0f0;
}
.qty-value {
    width: 35px;
    text-align: center;
    font-weight: 600;
    font-size: 13px;
}
.remove-btn {
    width: 30px;
    height: 30px;
    border: none;
    background: #fee2e2;
    color: #dc3545;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}
.remove-btn:hover {
    background: #dc3545;
    color: #fff;
}

/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 50px 20px;
}
.empty-cart-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
    border-radius: 50%;
    margin: 0 auto 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    color: #bbb;
}
.empty-cart h5 {
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
}
.empty-cart p {
    color: #888;
    font-size: 14px;
    margin-bottom: 25px;
}
.btn-shop-now {
    display: inline-flex;
    align-items: center;
    padding: 12px 30px;
    background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
    color: #fff;
    border-radius: 50px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s;
}
.btn-shop-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(4, 150, 255, 0.3);
    color: #fff;
}

/* Cart Footer */
.sidebar-cart-footer {
    padding: 20px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
    flex-shrink: 0;
}
.cart-subtotal {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.cart-subtotal span:first-child {
    font-size: 15px;
    color: #666;
}
.subtotal-amount {
    font-size: 22px;
    font-weight: 700;
    color: #333;
}
.shipping-note {
    font-size: 12px;
    color: #888;
    text-align: center;
    margin-bottom: 15px;
}
.cart-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.btn-view-cart,
.btn-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 14px 20px;
    border-radius: 10px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s;
}
.btn-view-cart {
    background: #fff;
    color: #333;
    border: 1px solid #e0e0e0;
}
.btn-view-cart:hover {
    background: #f5f5f5;
    color: #333;
}
.btn-checkout {
    background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
    color: #fff;
}
.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(4, 150, 255, 0.3);
    color: #fff;
}

/* Mobile */
@media (max-width: 480px) {
    #sidebarCart {
        width: 100% !important;
        right: -100% !important;
    }
    #sidebarCart.active {
        right: 0 !important;
    }
}
</style>

<script>
// Define cart functions globally
window.openSidebarCart = function() {
    var cart = document.getElementById('sidebarCart');
    var overlay = document.getElementById('cartOverlay');
    if (cart && overlay) {
        cart.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
};

window.closeSidebarCart = function() {
    var cart = document.getElementById('sidebarCart');
    var overlay = document.getElementById('cartOverlay');
    if (cart && overlay) {
        cart.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
};

// Backwards compatibility
var openSidebarCart = window.openSidebarCart;
var closeSidebarCart = window.closeSidebarCart;

// Update cart quantity
window.updateCartQty = function(rowId, change) {
    var qtyValueEl = document.getElementById('qty-' + rowId);
    if (!qtyValueEl) return;
    var itemRoot = document.querySelector('.sidebar-cart-item[data-row-id="' + rowId + '"]');
    var priceEl = itemRoot ? itemRoot.querySelector('.cart-item-price .price') : null;
    var displayQtyEl = itemRoot ? itemRoot.querySelector('.cart-item-price .qty') : null;
    var totalEl = itemRoot ? itemRoot.querySelector('.cart-item-price .total') : null;
    var currentQty = parseInt(qtyValueEl.textContent);
    var newQty = currentQty + change;
    if (newQty < 1) newQty = 1;
    qtyValueEl.textContent = newQty;
    if (displayQtyEl) displayQtyEl.textContent = newQty;
    if (priceEl && totalEl) {
        var unitPrice = parseFloat((priceEl.textContent || '0').replace(/[^\d.]/g, '')) || 0;
        totalEl.textContent = '= ৳' + (unitPrice * newQty).toLocaleString();
    }
    
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) return;
    
    fetch('/cart/update/' + rowId, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity: newQty })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            // Update cart count in header
            document.querySelectorAll('.cart-count').forEach(function(el) {
                el.textContent = data.cartCount;
            });
            // Update subtotal
            var subtotalEl = document.querySelector('.subtotal-amount');
            if (subtotalEl) {
                subtotalEl.textContent = '৳' + data.subtotal.toLocaleString();
            }
            // Sync item total from server if provided
            if (totalEl && typeof data.itemTotal === 'number') {
                totalEl.textContent = '= ৳' + data.itemTotal.toLocaleString();
            }
            // Show toast if available
            if (typeof showToast === 'function') {
                showToast('success', 'Cart updated!');
            }
        } else {
            // Revert UI on failure
            qtyValueEl.textContent = currentQty;
            if (displayQtyEl) displayQtyEl.textContent = currentQty;
            if (priceEl && totalEl) {
                var unitPrice2 = parseFloat((priceEl.textContent || '0').replace(/[^\d.]/g, '')) || 0;
                totalEl.textContent = '= ৳' + (unitPrice2 * currentQty).toLocaleString();
            }
        }
    })
    .catch(function(e) { 
        console.error('Error:', e);
        // Revert UI on error
        qtyValueEl.textContent = currentQty;
        if (displayQtyEl) displayQtyEl.textContent = currentQty;
        if (priceEl && totalEl) {
            var unitPrice3 = parseFloat((priceEl.textContent || '0').replace(/[^\d.]/g, '')) || 0;
            totalEl.textContent = '= ৳' + (unitPrice3 * currentQty).toLocaleString();
        }
    });
};

// Remove item from cart
window.removeFromCart = function(rowId) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) return;
    
    // Find and fade out the item
    var itemEl = document.querySelector('.sidebar-cart-item[data-row-id="' + rowId + '"]');
    if (itemEl) {
        itemEl.style.opacity = '0.5';
        itemEl.style.pointerEvents = 'none';
    }
    
    fetch('/cart/remove/' + rowId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            // Remove item from DOM
            if (itemEl) {
                itemEl.remove();
            }
            // Update cart count
            document.querySelectorAll('.cart-count').forEach(function(el) {
                el.textContent = data.cartCount;
            });
            // Update items count text
            var itemsText = document.querySelector('.cart-items-count');
            if (itemsText) {
                itemsText.textContent = data.cartCount + (data.cartCount === 1 ? ' Item' : ' Items');
            }
            // Update subtotal
            var subtotalEl = document.querySelector('.subtotal-amount');
            if (subtotalEl) {
                subtotalEl.textContent = '৳' + data.subtotal.toLocaleString();
            }
            // Show toast
            if (typeof showToast === 'function') {
                showToast('success', 'Item removed from cart!');
            }
            // If cart is empty, show empty state
            if (data.cartCount === 0) {
                location.reload();
            }
        }
    })
    .catch(function(e) { 
        console.error('Error:', e);
        if (itemEl) {
            itemEl.style.opacity = '1';
            itemEl.style.pointerEvents = 'auto';
        }
    });
};

// Load and open variant selector
window.openVariantSelector = function(rowId) {
    var itemEl = document.querySelector('.sidebar-cart-item[data-row-id="' + rowId + '"]');
    if (!itemEl) return;
    var wrap = itemEl.querySelector('.variant-select-wrap');
    var select = itemEl.querySelector('.variant-select');
    var productId = itemEl.dataset.productId;
    if (!wrap || !select || !productId) return;
    wrap.style.display = 'block';
    if (select.options.length > 0) return;
    fetch('/product/' + productId + '/variants', {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(function(r){ return r.json(); })
    .then(function(data){
        var variants = (data && data.variants) ? data.variants : [];
        variants.forEach(function(v){
            var opt = document.createElement('option');
            opt.value = v.id;
            opt.textContent = v.name || (v.sku || ('Variant ' + v.id));
            select.appendChild(opt);
        });
    });
};

// Apply selected variant: add new item with selected variant and remove old
window.applyVariantChange = function(rowId) {
    var itemEl = document.querySelector('.sidebar-cart-item[data-row-id="' + rowId + '"]');
    if (!itemEl) return;
    var select = itemEl.querySelector('.variant-select');
    var qtyEl = itemEl.querySelector('.qty-value');
    var productId = itemEl.dataset.productId;
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!select || !qtyEl || !productId || !csrfToken) return;
    var variantId = select.value;
    var qty = parseInt(qtyEl.textContent) || 1;

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ product_id: productId, variant_id: variantId, quantity: qty })
    })
    .then(function(r){ return r.json(); })
    .then(function(addData){
        if (addData && addData.success) {
            return fetch('/cart/remove/' + rowId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function(r){ return r.json(); })
              .then(function(remData){
                  location.reload();
              });
        }
    })
    .catch(function(e){
        console.error('Variant change error:', e);
    });
};

// Close on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSidebarCart();
});
</script>
