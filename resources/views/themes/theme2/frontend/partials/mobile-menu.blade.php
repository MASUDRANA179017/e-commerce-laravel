<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; opacity: 0; visibility: hidden; transition: all 0.3s;"></div>

<!-- Mobile Menu -->
<div class="mobile-menu" style="position: fixed; top: 0; left: -320px; width: 320px; height: 100%; background: #fff; z-index: 9999; overflow-y: auto; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 5px 0 30px rgba(0,0,0,0.1);">
    
    <!-- Menu Header -->
    <div class="mobile-menu-header" style="padding: 20px; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); display: flex; align-items: center; justify-content: space-between;">
        <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
            <div class="logo-icon me-2" style="width: 40px; height: 40px; background: #0496ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-cart-shopping text-white" style="font-size: 18px;"></i>
            </div>
            <div class="logo-text">
                <h5 class="mb-0 text-white" style="font-weight: 700;">Grow<span style="color: #0496ff;">Up</span></h5>
            </div>
        </a>
        <button class="close-mobile-menu" style="width: 36px; height: 36px; border: none; background: rgba(255,255,255,0.1); border-radius: 50%; color: #fff; font-size: 18px; cursor: pointer; transition: all 0.3s;">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    
    <!-- User Info (If Logged In) -->
    @auth
    <div class="mobile-user-info" style="padding: 20px; background: #f8f9fa; border-bottom: 1px solid #eee;">
        <div class="d-flex align-items-center gap-3">
            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px;">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <h6 class="mb-0" style="font-weight: 600; color: #333;">{{ Auth::user()->name ?? 'User' }}</h6>
                <small style="color: #888;">{{ Auth::user()->email ?? '' }}</small>
            </div>
        </div>
    </div>
    @endauth
    
    <!-- Mobile Search -->
    <div class="mobile-search" style="padding: 20px;">
        <form action="{{ route('shop.index') }}" method="GET">
            <div class="input-group" style="border: 2px solid #e9ecef; border-radius: 50px; overflow: hidden;">
                <input type="text" name="search" class="form-control border-0" placeholder="Search products..." style="padding: 12px 20px; font-size: 14px;">
                <button type="submit" class="btn" style="background: #0496ff; color: #fff; padding: 0 20px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Navigation Links -->
    <nav class="mobile-nav" style="padding: 0 20px;">
        <ul class="list-unstyled mb-0">
            <li>
                <a href="{{ route('home') }}" class="mobile-nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('home') ? 'active' : '' }}" style="padding: 15px 0; border-bottom: 1px solid #eee; color: {{ request()->routeIs('home') ? '#0496ff' : '#333' }}; text-decoration: none; font-weight: 500; font-size: 15px; transition: all 0.3s;">
                    <span><i class="fa-solid fa-home me-3" style="color: #0496ff; width: 20px;"></i> Home</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #ccc;"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('shop.index') }}" class="mobile-nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('shop.*') ? 'active' : '' }}" style="padding: 15px 0; border-bottom: 1px solid #eee; color: {{ request()->routeIs('shop.*') ? '#0496ff' : '#333' }}; text-decoration: none; font-weight: 500; font-size: 15px; transition: all 0.3s;">
                    <span><i class="fa-solid fa-shopping-bag me-3" style="color: #0496ff; width: 20px;"></i> Shop</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #ccc;"></i>
                </a>
            </li>
            
            <!-- Categories Submenu -->
            <li class="has-submenu">
                <a href="javascript:void(0)" class="mobile-nav-link d-flex align-items-center justify-content-between" style="padding: 15px 0; border-bottom: 1px solid #eee; color: #333; text-decoration: none; font-weight: 500; font-size: 15px; transition: all 0.3s;">
                    <span><i class="fa-solid fa-th-large me-3" style="color: #0496ff; width: 20px;"></i> Categories</span>
                    <i class="fa-solid fa-chevron-down submenu-toggle" style="font-size: 12px; color: #ccc; transition: all 0.3s;"></i>
                </a>
                <ul class="submenu list-unstyled" style="display: none; background: #f8f9fa; margin: 0 -20px; padding: 10px 30px;">
                    @php
                        try {
                            $mobileCategories = \App\Models\Admin\Product\ProductCategory::whereNull('parent_id')->where('show_on_menu', true)->orderBy('order')->limit(10)->get();
                        } catch (\Exception $e) {
                            $mobileCategories = collect();
                        }
                    @endphp
                    @foreach($mobileCategories as $category)
                    <li>
                        <a href="{{ route('shop.index', ['category' => $category->name]) }}" style="display: block; padding: 10px 0; color: #666; text-decoration: none; font-size: 14px; border-bottom: 1px dashed #e0e0e0;">
                            <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i>
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            
            <li>
                <a href="{{ route('frontend.about') }}" class="mobile-nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('frontend.about') ? 'active' : '' }}" style="padding: 15px 0; border-bottom: 1px solid #eee; color: {{ request()->routeIs('frontend.about') ? '#0496ff' : '#333' }}; text-decoration: none; font-weight: 500; font-size: 15px; transition: all 0.3s;">
                    <span><i class="fa-solid fa-info-circle me-3" style="color: #0496ff; width: 20px;"></i> About Us</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #ccc;"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('frontend.contact') }}" class="mobile-nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('frontend.contact') ? 'active' : '' }}" style="padding: 15px 0; border-bottom: 1px solid #eee; color: {{ request()->routeIs('frontend.contact') ? '#0496ff' : '#333' }}; text-decoration: none; font-weight: 500; font-size: 15px; transition: all 0.3s;">
                    <span><i class="fa-solid fa-envelope me-3" style="color: #0496ff; width: 20px;"></i> Contact</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #ccc;"></i>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Auth Links -->
    <div class="mobile-auth" style="padding: 20px; margin-top: auto;">
        @guest
        <div class="d-grid gap-2">
            <a href="{{ route('login') }}" class="btn" style="background: #f5f5f5; color: #333; padding: 12px; border-radius: 10px; font-weight: 500;">
                <i class="fa-regular fa-user me-2"></i> Login
            </a>
            <a href="{{ route('register') }}" class="btn" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); color: #fff; padding: 12px; border-radius: 10px; font-weight: 500;">
                <i class="fa-solid fa-user-plus me-2"></i> Create Account
            </a>
        </div>
        @else
        <div class="d-grid gap-2">
            <a href="{{ route('dashboard') }}" class="btn" style="background: #f5f5f5; color: #333; padding: 12px; border-radius: 10px; font-weight: 500;">
                <i class="fa-solid fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn w-100" style="background: #dc3545; color: #fff; padding: 12px; border-radius: 10px; font-weight: 500;">
                    <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
        @endguest
    </div>
    
    <!-- Contact Info -->
    <div class="mobile-contact" style="padding: 20px; background: #f8f9fa; margin-top: 20px;">
        <h6 style="font-weight: 600; color: #333; margin-bottom: 15px;">Contact Us</h6>
        <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center mb-2">
                <i class="fa-solid fa-phone me-2" style="color: #0496ff; width: 20px;"></i>
                <a href="tel:+8801713269591" style="color: #666; text-decoration: none; font-size: 14px;">+880 1713-269591</a>
            </li>
            <li class="d-flex align-items-center mb-2">
                <i class="fa-regular fa-envelope me-2" style="color: #0496ff; width: 20px;"></i>
                <a href="mailto:info@growup.com" style="color: #666; text-decoration: none; font-size: 14px;">info@growup.com</a>
            </li>
            <li class="d-flex align-items-start">
                <i class="fa-solid fa-location-dot me-2 mt-1" style="color: #0496ff; width: 20px;"></i>
                <span style="color: #666; font-size: 14px;">Dhaka, Bangladesh</span>
            </li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const closeMobileMenu = document.querySelector('.close-mobile-menu');
    
    function openMenu() {
        mobileMenu.style.left = '0';
        mobileMenuOverlay.style.opacity = '1';
        mobileMenuOverlay.style.visibility = 'visible';
        document.body.style.overflow = 'hidden';
    }
    
    function closeMenu() {
        mobileMenu.style.left = '-320px';
        mobileMenuOverlay.style.opacity = '0';
        mobileMenuOverlay.style.visibility = 'hidden';
        document.body.style.overflow = '';
    }
    
    if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', openMenu);
    if (closeMobileMenu) closeMobileMenu.addEventListener('click', closeMenu);
    if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMenu);
    
    // Submenu toggle
    document.querySelectorAll('.has-submenu > a').forEach(function(item) {
        item.addEventListener('click', function() {
            const submenu = this.nextElementSibling;
            const icon = this.querySelector('.submenu-toggle');
            if (submenu.style.display === 'none' || submenu.style.display === '') {
                submenu.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
            } else {
                submenu.style.display = 'none';
                icon.style.transform = 'rotate(0)';
            }
        });
    });
});
</script>
