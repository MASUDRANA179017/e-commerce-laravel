<!-- Cart Overlay -->
<div class="cart-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; opacity: 0; visibility: hidden; transition: all 0.3s;"></div>

<!-- Sidebar Cart -->
<div class="sidebar-cart" style="position: fixed; top: 0; right: -420px; width: 420px; max-width: 100%; height: 100%; background: #fff; z-index: 10001; display: flex; flex-direction: column; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: -5px 0 30px rgba(0,0,0,0.1);">
    
    <!-- Cart Header -->
    <div class="cart-header" style="padding: 20px 25px; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); display: flex; align-items: center; justify-content: space-between;">
        <div class="d-flex align-items-center">
            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                <i class="fa-solid fa-shopping-bag text-white" style="font-size: 18px;"></i>
            </div>
            <div>
                <h5 class="mb-0 text-white" style="font-weight: 600;">Shopping Cart</h5>
                <small style="color: rgba(255,255,255,0.6);" class="cart-items-text">0 Items</small>
            </div>
        </div>
        <button class="close-cart" style="width: 36px; height: 36px; border: none; background: rgba(255,255,255,0.1); border-radius: 50%; color: #fff; font-size: 18px; cursor: pointer; transition: all 0.3s;">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    
    <!-- Cart Items -->
    <div class="cart-items-wrapper" style="flex: 1; overflow-y: auto; padding: 20px;">
        <!-- Empty Cart State -->
        <div class="empty-cart text-center" style="padding: 40px 20px;">
            <div style="width: 100px; height: 100px; background: #f5f5f5; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-shopping-cart" style="font-size: 40px; color: #ccc;"></i>
            </div>
            <h5 style="color: #333; margin-bottom: 10px;">Your cart is empty</h5>
            <p style="color: #888; font-size: 14px; margin-bottom: 20px;">Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); color: #fff; padding: 12px 30px; border-radius: 50px; font-weight: 500;">
                <i class="fa-solid fa-shopping-bag me-2"></i> Start Shopping
            </a>
        </div>
        
        <!-- Cart Items List (Hidden when empty) -->
        <div class="cart-items-list" style="display: none;">
            <!-- Sample Cart Item -->
            <div class="cart-item d-flex gap-3 mb-3 pb-3" style="border-bottom: 1px solid #eee;">
                <div class="cart-item-image" style="width: 80px; height: 80px; flex-shrink: 0; border-radius: 10px; overflow: hidden; background: #f5f5f5;">
                    <img src="{{ asset('frontend/images/product-placeholder.jpg') }}" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="cart-item-details flex-grow-1">
                    <h6 style="font-weight: 500; color: #333; margin-bottom: 5px; font-size: 14px; line-height: 1.4;">
                        <a href="#" style="color: inherit; text-decoration: none;">Sample Product Name</a>
                    </h6>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span style="font-weight: 600; color: #0496ff;">৳500</span>
                        <span style="color: #ccc;">×</span>
                        <span style="color: #666;">1</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="qty-controls d-flex align-items-center" style="border: 1px solid #e0e0e0; border-radius: 6px; overflow: hidden;">
                            <button class="qty-btn" style="width: 28px; height: 28px; border: none; background: #f5f5f5; color: #333; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="text" value="1" readonly style="width: 35px; height: 28px; border: none; text-align: center; font-size: 13px; font-weight: 500;">
                            <button class="qty-btn" style="width: 28px; height: 28px; border: none; background: #f5f5f5; color: #333; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <button class="remove-item" style="width: 28px; height: 28px; border: none; background: #fee; color: #dc3545; border-radius: 6px; cursor: pointer; font-size: 12px; transition: all 0.3s;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cart Footer -->
    <div class="cart-footer" style="padding: 20px 25px; background: #f8f9fa; border-top: 1px solid #eee;">
        <!-- Subtotal -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <span style="font-size: 15px; color: #666;">Subtotal:</span>
            <span class="cart-subtotal" style="font-size: 20px; font-weight: 700; color: #333;">৳0.00</span>
        </div>
        
        <!-- Shipping Note -->
        <p style="font-size: 12px; color: #888; margin-bottom: 15px; text-align: center;">
            <i class="fa-solid fa-truck me-1"></i> Free shipping on orders over ৳5,000
        </p>
        
        <!-- Action Buttons -->
        <div class="d-grid gap-2">
            <a href="{{ route('cart.index') }}" class="btn" style="background: #f5f5f5; color: #333; padding: 14px; border-radius: 10px; font-weight: 500; text-decoration: none; text-align: center;">
                <i class="fa-solid fa-shopping-cart me-2"></i> View Cart
            </a>
            <a href="{{ route('checkout.index') }}" class="btn" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); color: #fff; padding: 14px; border-radius: 10px; font-weight: 500; text-decoration: none; text-align: center;">
                <i class="fa-solid fa-lock me-2"></i> Checkout
            </a>
        </div>
    </div>
</div>

<style>
    .sidebar-cart.active {
        right: 0 !important;
    }
    .cart-overlay.active {
        opacity: 1 !important;
        visibility: visible !important;
    }
    .close-cart:hover {
        background: rgba(255,255,255,0.2);
    }
    .qty-btn:hover {
        background: #e0e0e0;
    }
    .remove-item:hover {
        background: #dc3545;
        color: #fff;
    }
    .cart-item:hover {
        background: #fafafa;
        margin-left: -10px;
        margin-right: -10px;
        padding-left: 10px;
        padding-right: 10px;
        border-radius: 10px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const openCartBtn = document.querySelector('.open-cart');
    const sidebarCart = document.querySelector('.sidebar-cart');
    const cartOverlay = document.querySelector('.cart-overlay');
    const closeCartBtn = document.querySelector('.close-cart');
    
    function openCart() {
        sidebarCart.classList.add('active');
        cartOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeCart() {
        sidebarCart.classList.remove('active');
        cartOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (openCartBtn) openCartBtn.addEventListener('click', openCart);
    if (closeCartBtn) closeCartBtn.addEventListener('click', closeCart);
    if (cartOverlay) cartOverlay.addEventListener('click', closeCart);
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebarCart.classList.contains('active')) {
            closeCart();
        }
    });
});
</script>
