<div class="sidebar-cart">
    <div class="der">
        <button class="close-cart">
            <span class="close-icon">&times;</span>
        </button>
        <h2>Shopping Bag <span class="count badge bg-primary rounded-circle ms-2">0</span></h2>
        
        <div class="cart-items" id="sidebar-cart-items">
            <!-- Cart items will be loaded via AJAX -->
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-shopping-cart fa-3x mb-3"></i>
                <p>Your cart is empty</p>
            </div>
        </div>
        
        <div class="totals mt-auto">
            <div class="subtotal d-flex justify-content-between py-3 border-top">
                <span class="label fw-bold">Subtotal:</span>
                <span class="amount fw-bold">$<span class="total-price" id="sidebar-cart-total">0.00</span></span>
            </div>
        </div>
        
        <div class="action-buttons">
            <a class="view-cart-button" href="{{ route('cart.index') }}" aria-label="go to cart">View Cart</a>
            <a class="checkout-button" href="{{ route('checkout.index') }}" aria-label="go to checkout">
                Checkout <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>
    </div>
</div>
<div class="cart-backdrop"></div>

